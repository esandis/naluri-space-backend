<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PiIteration;

/**
 * Pi Controller.
 * @Route("/api", name="api_")
 */
class PiController
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * Return latest Pi Value.
     * @Rest\Get("/pi")
     *
     * @return Response
     */
    public function getLatestPiValue()
    {
        $latestPi = $this->em->getRepository(PiIteration::class)->findByLatestIteration();

        return new Response(json_encode(['pi' => $latestPi->getPi()]));
    }

    public function countNextPiIteration() {
        $latestPi = $this->em->getRepository(PiIteration::class)->findByLatestIteration();

        $latestPiDigit = $latestPi ? $latestPi->getDigit() : 0;
        $nextPiDigit = $latestPiDigit + 1;

        $newPi = $this->getPiWithDigits($nextPiDigit);

        $this->saveNewPiIteration($nextPiDigit, $newPi);

        return $newPi;
    }

    private function getPiWithDigits($precision)
    {
        $num = 0;$k = 0;
        bcscale($precision+3);
        $limit = ($precision+3)/14;

        while($k < $limit)
        {
            $num = bcadd($num, bcdiv(bcmul(bcadd('13591409',bcmul('545140134', $k)),bcmul(bcpow(-1, $k), $this->bcfact(6*$k))),bcmul(bcmul(bcpow('640320',3*$k+1),bcsqrt('640320')), bcmul($this->bcfact(3*$k), bcpow($this->bcfact($k),3)))));
            ++$k;
        }

        return bcdiv(1, (bcmul(12, ($num))), $precision);
    }

    private function bcfact($n)
    {
        return ($n == 0 || $n== 1) ? 1 : bcmul($n,$this->bcfact($n-1));
    }

    private function saveNewPiIteration($digit, $pi) {
        $piIteration = new PiIteration();
        $piIteration->setDigit($digit);
        $piIteration->setPi($pi);

        $this->em->persist($piIteration);
        $this->em->flush();
    }

}
