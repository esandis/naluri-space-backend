<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PiIteration;

class CountNextPiIterationCommand extends Command
{
    protected static $defaultName = 'app:count-next-pi-iteration';

    public function __construct(string $name = null, EntityManagerInterface $em) {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $latestPi = $this->em->getRepository(PiIteration::class)->findByLatestIteration();

        $latestPiDigit = $latestPi ? $latestPi->getDigit() : 0;
        $nextPiDigit = $latestPiDigit + 1;

        if ($nextPiDigit > 1000) {
            return;
        }

        $newPi = $this->getPiWithDigits($nextPiDigit);

        $this->saveNewPiIteration($nextPiDigit, $newPi);

        return Command::SUCCESS;
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
