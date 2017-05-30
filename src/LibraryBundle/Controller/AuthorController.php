<?php

namespace LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthorController extends Controller
{
    /**
     * @Route("/author/{id}", name="author_view", requirements={"id": "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $author = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Author')
            ->find($id);

        if (!$author) {
            $this->addFlash('notice', 'Author not found');
            return $this->redirectToRoute('book_list');
        }

        return ['author' => $author];
    }
}
