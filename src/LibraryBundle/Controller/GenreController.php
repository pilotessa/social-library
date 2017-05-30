<?php

namespace LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GenreController extends Controller
{
    /**
     * @Route("/genre/{id}", name="genre_view", requirements={"id": "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $genre = $this
            ->getDoctrine()
            ->getRepository('LibraryBundle:Genre')
            ->find($id);

        if (!$genre) {
            $this->addFlash('notice', 'Genre not found');
            return $this->redirectToRoute('book_list');
        }

        return ['genre' => $genre];
    }
}
