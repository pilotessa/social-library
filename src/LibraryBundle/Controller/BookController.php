<?php

namespace LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BookController extends Controller
{
    /**
     * @Route("/", name="book_home")
     * @Template()
     */
    public function indexAction()
    {
        return [];
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
                ['status' => 'Approved'],
                ['title' => 'ASC']
            );

        return ['books' => $books];
    }

    /**
     * @Route("/book/view/{id}", name="book_view", requirements={"id": "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $book = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Book')
            ->find($id);

        if (!$book) {
            $this->addFlash('warning', 'Book not found');

            return $this->redirectToRoute('book_index');
        }

        return ['book' => $book];
    }

}
