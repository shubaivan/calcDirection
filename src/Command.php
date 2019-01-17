<?php

namespace App;

/**
 * Class Command
 * @package App
 */
class Command
{

    /** @var float $x */
    protected $x;

    /** @var float $y */
    protected $y;

    /** @var float $deg */
    protected $deg = 0.0;

    /** @var array $actions */
    protected $actions = [];

    /** @var array $points */
    protected $points = [];

    public function __construct(string $rawCommand)
    {
        /** @var array $parsed_command Command array */
        $parsed_command = $this->parse($rawCommand);

        // Set command start points
        $this->x = (float)array_shift($parsed_command);
        $this->y = (float)array_shift($parsed_command);

        $this->actions = $parsed_command;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getEndPoint()
    {
        while(!empty($this->actions)) {

            /** @var string $action */
            $action = trim(array_shift($this->actions));

            /** @var float $value Action value */
            $value = array_shift($this->actions);

            if (is_null($value)) {
                throw new \InvalidArgumentException("was not found value for action '$action'");
            } elseif ($action !== 'start' && $action !== 'walk' && $action !== 'turn') {
                throw new \InvalidArgumentException("'$action' is not supported");
            }

            $this->{$action}((float)$value);
        }

        return [ 'x' => $this->x, 'y' => $this->y ];
    }

    /**
     * @param string $rawCommand
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function parse(string $rawCommand) : array
    {
        /** @var  $result */
        $result = explode(' ', $rawCommand);

        if (count($result) < 4) {
            throw new \InvalidArgumentException("Command '$rawCommand' is to short");
        }

        return $result;
    }

    /**
     * @param float $deg
     * @return Command
     */
    protected function start(float $deg) : Command
    {
        $this->deg = $deg;

        return $this;
    }

    /**
     * @param float $distance
     * @return Command
     */
    protected function walk(float $distance) : Command
    {
        $this->x += $distance * cos(deg2rad($this->deg));
        $this->y += $distance * sin(deg2rad($this->deg));

        $this->points[] = [ 'x' => $this->x, 'y' => $this->y ];

        return $this;
    }

    /**
     * @param float $deg
     * @return Command
     */
    protected function turn(float $deg) : Command
    {
        $this->deg += $deg;

        return $this;
    }
}