<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commission;
use App\Entity\Institution;
use App\Entity\Journal;
use App\Entity\LinePurchase;
use App\Entity\lineStock;
use App\Entity\Exitt;
use App\Entity\LineExitt;
use App\Entity\Menu;
use App\Entity\NbMeal;
use App\Form\ExittType;
use App\Repository\ExittRepository;
use App\Repository\LineExittRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




/**
 * @Route("/exitt")
 * @IsGranted("ROLE_ENTREPRISE", message="No access! Get out!")
 */
class ExittController extends AbstractController
{
    /**
     * @Route ("/", name="exitt_index", methods={"GET"} )
     */

    public function index(ExittRepository $exittRepository)
    {
        return $this->render('exitt/index.html.twig',[
            'exitts' =>$exittRepository->findAll()
        ]);
    }
    /**
     * @Route("/ajout/exitt", name="ajout-exitt")
     * @Route("/modifier/exitt/{id}", name="modifier-exitt" )
     * @Route("/new", name="exitt_new")
     *
     */
    public  function exitt($id=null, Request $request)
    {
	    $data_exit = $this->getDoctrine()->getRepository(Exitt::class)->checkOneExitByDate();

        $em = $this->getDoctrine()->getManager();
        if (is_null($id))
            $exitt = new Exitt();
        else
            $exitt =$em->find(Exitt::class, $id);

        $form = $this-> createForm(ExittType::class, $exitt);

        $oldLineExitt = new ArrayCollection();
        foreach ($exitt->getLineExitts() as $lineExitt)
            $oldLineExitt->add($lineExitt);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()){
                foreach ($oldLineExitt as $lineExitt) {
	                if (false=== $exitt->getLineExitts()->contains($lineExitt))
		                $em->remove($lineExitt);
                }
                foreach ($exitt->getLineExitts() as $lineExitt) {
                    $lineExitt->setExitt($exitt);

	                // find Line Purchase By Article: mise à jour du stock
	                $repositoryLinePurchase = $this->getDoctrine()->getRepository(LinePurchase::class);
	                $repositoryLineStock = $this->getDoctrine()->getRepository(LineStock::class);
	                $findLinePurchaseByArticle = $repositoryLinePurchase->findOneBy(['article' => $lineExitt->getArticle()]);
	                $findLineStockByLinePurchase = $repositoryLineStock->findOneBy(['line_purchase' => $findLinePurchaseByArticle]);
	                if ($findLineStockByLinePurchase) {
		                $old_quantity = $findLineStockByLinePurchase->getQtyUpdate();
		                $new_quantity = $lineExitt->getQuantity();
		                $etat=$old_quantity-$new_quantity;
		                if ($etat < $findLineStockByLinePurchase->getQuantityAlerte()) {
			                $this->addFlash(
				                'danger',
				                ' لا يمكن، الكمية المطلوبة من مادة: '.$lineExitt->getArticle()->getName().'    اقل من الكمية المتوفرة بالمخزون '.$old_quantity);
			                return $this->redirectToRoute("ajout-exitt");
                        }
                        else {
                            $findLineStockByLinePurchase->setQtyUpdate($etat);
                            $findLineStockByLinePurchase->setOldQty($old_quantity);
                       }

                // le prix unitaire de line exitt
                        $lineExitt->setUnitPrice($findLineStockByLinePurchase->getUnitPrice());

                        $em->flush();
	                }
                }

                /* ---calcul du prix total de chaque exitt---*/
               $totalPrice=0;
                foreach ($exitt->getLineExitts() as $lineExitt)
                {
                    //$lineExitt->setTotalPrice($lineExitt->getQuantity()*$lineExitt->getUnitPrice()*(1+($lineExitt->getTax()/ 100)));

                    $totalPrice += $lineExitt->getQuantity()*$lineExitt->getUnitPrice();
                }
                $exitt->setTotalPrice($totalPrice);

                $em->persist($exitt);
                $em->flush();
                $this->addFlash(
                                 'success',
                                 'تمت العملية بنجاح');
                return $this->redirectToRoute("exitt_index");
            }
        }
        $exitts=$em->getRepository(Exitt::class) ->findAll();
        $article = $em->getRepository(Article::class)->findAll();

        return $this->render('exitt/exitt.html.twig',[
            'form'=> $form->createView(),
            'exitts' => $exitts,
            'articles' =>$article,
	        'data_exit' => $data_exit
        ]);
    }
    /**
     * @Route("/{id}", name="exitt_show", methods={"GET"})
     */
    public function show(Exitt $exitt): Response
    {
        return $this->render('exitt/show.html.twig', [
            'exitt' => $exitt,
        ]);
    }

    /**
     * @Route("/{id}", name="exitt_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Exitt $exitt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exitt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exitt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exitt_index');
    }
}
