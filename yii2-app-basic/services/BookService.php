<?php

namespace app\services;

use app\models\Book;
use app\repositories\AuthorRepository;
use app\repositories\BookRepository;
use app\requests\BookRequest;
use app\services\SubscriptionService;
use app\services\FileService;
use Yii;

class BookService
{
    private $bookRepository;
    private $authorRepository;
    private $subscriptionService;
    private $fileService;

    public function __construct(
        BookRepository $bookRepository,
        AuthorRepository $authorRepository,
        SubscriptionService $subscriptionService,
        FileService $fileService
    ) {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->subscriptionService = $subscriptionService;
        $this->fileService = $fileService;
    }

    /**
     * @param Book $book
     * @param array $authorIds
     * @param \yii\web\UploadedFile|null $coverFile
     * @return bool
     */
    public function create(Book $book, array $authorIds = [], $coverFile = null, BookRequest $request = null)
    {
        $coverPath = null;
        if ($coverFile && $this->fileService->validateImage($coverFile)) {
            $coverPath = $this->fileService->upload($coverFile);
            if ($coverPath) {
                $book->cover_photo = $coverPath;
            }
        } elseif ($coverFile) {
            Yii::warning('Invalid image file uploaded', 'book');
        }

        if ($request) {
            $request->fillBook($book, $coverPath);
        }

        if (!$this->bookRepository->save($book)) {
            if ($coverPath) {
                $this->fileService->delete($coverPath);
            }
            return false;
        }

        $this->syncAuthors($book, $authorIds);
        $this->subscriptionService->notifySubscribers($book);

        return true;
    }

    /**
     * @param Book $book
     * @param array $authorIds
     * @param \yii\web\UploadedFile|null $coverFile
     * @return bool
     */
    public function update(Book $book, array $authorIds = [], $coverFile = null)
    {
        $oldCoverPath = $book->cover_photo;

        if ($coverFile && $this->fileService->validateImage($coverFile)) {
            $coverPath = $this->fileService->upload($coverFile, $oldCoverPath);
            if ($coverPath) {
                $book->cover_photo = $coverPath;
            }
        } elseif ($coverFile) {
            Yii::warning('Invalid image file uploaded', 'book');
        }

        if (!$this->bookRepository->save($book)) {
            if ($coverFile && $book->cover_photo !== $oldCoverPath && $book->cover_photo) {
                $this->fileService->delete($book->cover_photo);
                $book->cover_photo = $oldCoverPath;
            }
            return false;
        }

        $this->syncAuthors($book, $authorIds);

        return true;
    }

    /**
     * @param Book $book
     * @return bool
     */
    public function delete(Book $book)
    {
        if ($book->cover_photo) {
            $this->fileService->delete($book->cover_photo);
        }

        return $this->bookRepository->delete($book);
    }

    /**
     * @param Book $book
     * @param array $authorIds
     */
    private function syncAuthors(Book $book, array $authorIds)
    {
        $book->unlinkAll('authors', true);
        
        if (!empty($authorIds)) {
            $authors = $this->authorRepository->findByIds($authorIds);
            foreach ($authors as $author) {
                $book->link('authors', $author);
            }
        }
    }
}

