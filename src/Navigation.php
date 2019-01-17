<?php

namespace App;

/**
 * Class Navigation
 * @package App
 */
class Navigation
{
    /**
     * @var string
     */
    protected $input;

    public function __construct(string $input = '')
    {
        $this->input = $input;
    }

    /**
     * @param string $input
     * @return Navigation
     */
    public static function make(string $input) : Navigation
    {
        $self = new static($input);

        return $self;
    }

    /**
     * @return string
     */
    public function calc() : string
    {
        /** @var array $points Commands end points */
        $points = [];

        /** @var float $x_summary */
        $x_summary = 0.0;

        /** @var float $y_summary */
        $y_summary = 0.0;

        /** @var array $rawCommands */
        $rawCommands = explode(PHP_EOL, $this->input);

        foreach ($rawCommands as $rawCommand) {
            if (!trim($rawCommand)) {
                throw new \InvalidArgumentException('Command cannot be empty');
            }
            /** @var \App\Command $command */
            $command = new Command($rawCommand);

            /** @var array $end_point Current command end point */
            $end_point = $command->getEndPoint();

            $points[] = $end_point;

            $x_summary += $end_point['x'];
            $y_summary += $end_point['y'];
        }

        $average = [ 'x' => $x_summary / count($points), 'y' => $y_summary / count($points)];

        /** @var float $distance Result distance */
        $distance = 0;
        $commandDistance = [];
        foreach ($points as $key=>$point) {
            $commandDistance[] = $this->squaredDistance($point, $average);
        }

        $max = sqrt(max($commandDistance));
        $min = sqrt(min($commandDistance));

        return sprintf(
            "x = %.5f, y = %.5f max distance = %.5f, min distance = %.5f",
            $average['x'],
            $average['y'],
            $max,
            $min
        );
    }

    /**
     * @param array $start
     * @param array $end
     * @return float
     */
    protected function squaredDistance(array $start, array $end) : float
    {
        return (($start['x'] - $end['x']) ** 2) + (($start['y'] - $end['y']) ** 2);
    }

}