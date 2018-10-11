<?php

namespace Nucreativa\LaravelWordpressGraphQL\Helper;

/**
 * Estimated read time calculator helper. Use #begin() method as an entry point.
 *
 * @author Fanny Irawan Sutawanir (fannyirawans@gmail.com)
 *  _               _     _     _           _       _
 * | |_ ___ ___ ___| |___| |_  |_|___ _____| |_ _ _| |_
 * | '_| -_|_ -| -_| | -_| '_| | | -_|     | . | | |  _|
 * |_,_|___|___|___|_|___|_,_|_| |___|_|_|_|___|___|_|
 *                           |___|
 */
class ErtCalculator {

    /**
     * According to web, average reading speed is between 230-280 words per minute, so using 200 here is keeping some
     * limit to provide pessimistic reading time.
     * Most of people should read it faster.
     *
     * @see https://gist.github.com/mynameispj/3170442
     */
    const AVG_WORDS_PER_MINUTE = 200;

    const DEFAULT_MINUTE_FORMAT = '%s minute(s)';
    const DEFAULT_FULL_FORMAT = '%s minute(s) and %s second(s)';
    const DEFAULT_SECOND_FORMAT = '%s second(s)';
    
    /** @var $content string */
    private $content;
    /** @var $wordCount int */
    private $wordCount;
    
    private $minuteFormat;
    private $secondFormat;
    private $fullFormat;

    /**
     * ErtCalculator private constructor.
     * Prevent instantiation.
     *
     * @param $content string
     */
    private function __construct($content) {
        $this->content = $content;
    }

    /**
     * Entry point. Return new instance of ErtCalculator.
     *
     * @param $content string
     *
     * @return ErtCalculator
     */
    public static function begin($content) {
        $content = (string) $content;
        
        return new ErtCalculator($content);
    }

    /**
     * Set minute text format
     *
     * @param $minuteFormat string
     *
     * @return $this
     */
    public function minuteFormat($minuteFormat) {
        if(empty($minuteFormat) ) {
            return $this;
        }
        $this->minuteFormat = $minuteFormat;
        return $this;
    }

    /**
     * Set second text format
     *
     * @param $secondFormat string
     *
     * @return $this
     */
    public function secondFormat($secondFormat) {
        if(empty($secondFormat) ) {
            return $this;
        }
        $this->secondFormat = $secondFormat;
        return $this;
    }
    /**
     * Set full text format
     *
     * @param $fullFormat string
     *
     * @return $this
     */
    public function fullFormat($fullFormat) {
        if(empty($fullFormat) ) {
            return $this;
        }
        $this->fullFormat = $fullFormat;
        return $this;
    }
    
    /**
     * Get content word count
     *
     * @return int
     */
    public function getWordCount() {
        if($this->wordCount) {
            return $this->wordCount;
        }

        $this->wordCount = str_word_count(strip_tags($this->content) );
        return $this->wordCount;
    }

    /**
     * Return estimated reading time in minutes without decimal.
     *
     * @return float
     */
    public function getMinute() {
        return floor($this->getWordCount() / self::AVG_WORDS_PER_MINUTE);
    }

    /**
     * Return estimated reading time in seconds.
     *
     * @return float|int
     */
    public function getSecond() {
        return $this->getMinute() * 60;
    }

    /**
     * Return estimated reading time in array consist of minutes and remaining seconds
     *
     * example :
     * [
     *  'minute' => 6
     *  'second' => 30
     * ]
     *
     * @return array
     */
    public function getMinuteAndSecond() {
        return [
            'minute' => $this->getMinute(),
            'second' => floor($this->getWordCount() % self::AVG_WORDS_PER_MINUTE / (self::AVG_WORDS_PER_MINUTE / 60) )
        ];
    }

    /**
     * Return estimated reading time in string consist of minutes and remaining seconds
     *
     * example : 6 menit dan 15 detik membaca
     *
     * @return string
     */
    public function getFullText() {
        $data = $this->getMinuteAndSecond();
        return sprintf($this->getFullFormat(), $data['minute'], $data['second']);
    }

    /**
     * Return estimated reading time in string consist of minutes and remaining seconds
     *
     * example : 6 menit membaca
     *
     * @return string
     */
    public function getMinuteText() {
        $m = $this->getMinute();
        return sprintf($this->getMinuteFormat(), $m);
    }

    /**
     * Return estimated reading time in string with logical expression
     * - if below one minute, return ert in second string
     * - if equal or greater than one minute, return ert in minute string
     *
     * @return string
     */
    public function getText() {
        $data = $this->getMinuteAndSecond();
        if($data['minute'] < 1) {
            return sprintf($this->getSecondFormat(), $data['second']);
        }
        return sprintf($this->getMinuteFormat(), $data['minute']);
    }

    /**
     * Get minute text format
     *
     * @return string
     */
    private function getMinuteFormat() {
        if($this->minuteFormat) return $this->minuteFormat;
        return self::DEFAULT_MINUTE_FORMAT;
    }

    /**
     * Get second text format
     *
     * @return string
     */
    private function getSecondFormat() {
        if($this->secondFormat) return $this->secondFormat;
        return self::DEFAULT_SECOND_FORMAT;
    }

    /**
     * Get full text format
     *
     * @return string
     */
    private function getFullFormat() {
        if($this->fullFormat) return $this->fullFormat;
        return self::DEFAULT_FULL_FORMAT;
    }
}