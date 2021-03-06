<?php

namespace LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LibraryBundle\Entity\Book;
use LibraryBundle\Form\BookType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookController extends Controller
{
    /**
     * @Route("/", name="book_index")
     * @Template()
     */
    public function indexAction()
    {
        $genres = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Genre')
            ->findBy(
                [],
                ['name' => 'ASC']
            );

        $books = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->findBy(
                ['status' => 'Published'],
                ['publishedAt' => 'DESC'],
                6
            );

        return compact('genres', 'books');
    }

    /**
     * @Route("/book", name="book_list")
     * @Template()
     */
    public function listAction()
    {
        $books = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->findBy(
                ['status' => 'Published'],
                ['title' => 'ASC']
            );

        return ['books' => $books];
    }

    /**
     * @Route("/recent", name="book_recent")
     * @Template()
     */
    public function recentAction()
    {
        $books = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->findBy(
                ['status' => 'Published'],
                ['publishedAt' => 'DESC']
            );

        return ['books' => $books];
    }

    /**
     * @Route("/book/{id}", name="book_view", requirements={"id": "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $book = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->find($id);

        if (!$book) {
            $this->addFlash('notice', 'Book not found');
            return $this->redirectToRoute('book_list');
        }

        $relatedBooks = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->getRelatedBooks($book);

        return compact('book', 'relatedBooks');
    }

    /**
     * @Route("/book/add", name="book_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $book->getCover();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('uploads'),
                $fileName
            );

            $book->setCover($fileName);

            $em = $this->get('doctrine')->getManager();

            $em->persist($book);
            $em->flush();

            $this->addFlash('notice', 'Book saved');
            return $this->redirectToRoute('book_view', array('id' => $book->getId()));
        }

        return ['form' => $form->createView()];
    }
}
