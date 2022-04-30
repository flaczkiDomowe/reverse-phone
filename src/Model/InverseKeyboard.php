<?php

namespace App\Model;

use App\Entity\LetterKey;
use App\Entity\RulingKey;

use App\Model\Interfaces\CanContainCharacters;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class InverseKeyboard extends Command
{
    private $phone;
    private $outputCode;


    public function __construct(Phone $phone)
    {
        parent::__construct();
        $this->phone = $phone;
    }

    protected function configure()
    {
        $this->setName('phone-keyboard-coder')
            ->setDescription('Changes input sentence to telephone keyboard button clicks combination')
            ->addArgument('sentence', InputArgument::REQUIRED, 'Pass sentence');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $this->makeCodeFromString($input->getArgument('sentence'));
        $output->writeln(sprintf('Combination: %s',$this->outputCode ));
              return 1;
    }

    public function makeCodeFromString(string $string)
    {
        $charArray = str_split($string);
        $iter = 0;
        foreach ($charArray as $key => $char) {
            if ($iter == 0) {
                $this->phone->setUpperCase();
                $this->outputCode = $this->getCode($char);
            } else if($iter==1) {
                $this->concatCharCode($this->getCode($char));
            } else {
                $keyBefore=--$key;
                $keyBeforeBefore=--$keyBefore;
                if($charArray[$keyBefore]==' '&&$charArray[$keyBeforeBefore]==='.'){
                    $this->phone->setUpperCase();
                }
                $this->concatCharCode($this->getCode($char));
            }
            $iter++;
            $this->phone->setLowerCase();
        }
        return $this->outputCode;
    }

    private function getCode(string $char)
    {
        $code = "";
        $key = $this->findKey($char);
        if ($key instanceof LetterKey) {
            if ($key->checkIfLetterIsTheSameCaseState($char)) {
                $code = $key->press($char,self::class);
            } else {
                /** @var RulingKey $rulingKey */
                $rulingKey = $this->phone->getRulingKeys()['caseChange'];
                $code = $rulingKey->press($char,self::class);
                $code.=$key->press($char,self::class);
            }
        } else {
            $code = $key->press($char,self::class);
        }
        return $code;
    }


    private function concatCharCode($code)
    {
        $this->outputCode .= " " . $code;
    }

    private function findKey(string $char): CanContainCharacters
    {
        foreach ($this->phone->getKeysWhichContainsChars() as $key) {
            if ($key->contains($char)) {
                return $key;
            }
        }
        throw new InvalidArgumentException("Wprowadzone wyrażenie posiada niedozwolony znak: $char", 123);
    }
}