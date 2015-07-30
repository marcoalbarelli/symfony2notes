<?php
/**
 * Created by PhpStorm.
 * User: Marco Albarelli <info@marcoalbarelli.eu>
 * Date: 22/06/14
 * Time: 14.20
 */

require_once __DIR__ . '/AppKernel.php';

class AppTestKernel extends AppKernel
{
    private $kernelModifier;

    public function boot()
    {
        parent::boot();
        if ($kernelModifier = $this->kernelModifier) {
            $kernelModifier($this);
            $this->kernelModifier = null;
        };
    }

    public function setKernelModifier(\Closure $kernelModifier)
    {
        $this->kernelModifier = $kernelModifier;
        $this->shutdown();
    }
}


