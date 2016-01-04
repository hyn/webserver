<?php

namespace Hyn\Webserver\Solvers;

use Hyn\LetsEncrypt\Contracts\ChallengeSolverContract;
use Hyn\LetsEncrypt\Resources\Challenge;

class Http01Solver implements ChallengeSolverContract
{
    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @param Challenge $challenge
     * @param array     $payload
     *
     * @return bool
     */
    public function solve(Challenge $challenge, $payload = [])
    {
    }
}
