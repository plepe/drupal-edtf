<?php

namespace Drupal\edtf;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use EDTF\EdtfFactory;

/**
 * Twig extension for working with Extended Date/Time Format (EDTF) values.
 */
class TwigEDTFExtension extends AbstractExtension {
  /**
   * {@inheritdoc}
   */
  public function getFilters(): array {

    $filters = [
      new TwigFilter('edtf_validate', [$this, 'edtfValidate']),
      new TwigFilter('edtf_humanize', [$this, 'edtfHumanize']),
      new TwigFilter('edtf_year', [$this, 'edtfYear']),
      new TwigFilter('edtf_min', [$this, 'edtfMin']),
      new TwigFilter('edtf_max', [$this, 'edtfMax']),
    ];
    
    return $filters;
  }

  /**
   * {@inheritdoc}
   */
  public function init(): void {
    if (!isset($this->parser)) {
      $this->parser = \EDTF\EdtfFactory::newParser();
      $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $this->humanizer = \EDTF\EdtfFactory::newHumanizerForLanguage($langcode);
    }
  }

  /**
   * Checks the validty of an EDTF value.
   */
  public function edtfValidate (string|null $value): bool {
    $this->init();

    $parsingResult = $this->parser->parse($value ?? '');
    return $parsingResult->isValid();
  }


  /**
   * Returns an humanized version of an EDTF value.
   */
  public function edtfHumanize (string|null $value): string|null {
    $this->init();

    $parsingResult = $this->parser->parse($value ?? '');
    if (!$parsingResult->isValid()) {
      return null;
    }

    $edtfValue = $parsingResult->getEdtfValue();

    return $this->humanizer->humanize($edtfValue);
  }

  /**
   * Returns the year of an EDTF value.
   */
  public function edtfYear (string|null $value): int|null {
    $this->init();

    $parsingResult = $this->parser->parse($value ?? '');
    if (!$parsingResult->isValid()) {
      return null;
    }

    $edtfValue = $parsingResult->getEdtfValue();

    return $edtfValue->getYear();
  }

  /**
   * Returns the earliest timestamp of an EDTF value.
   */
  public function edtfMin (string|null $value): int|null {
    $this->init();

    $parsingResult = $this->parser->parse($value ?? '');
    if (!$parsingResult->isValid()) {
      return null;
    }

    $edtfValue = $parsingResult->getEdtfValue();

    return $edtfValue->getMin();
  }

  /**
   * Returns the latest timestamp of an EDTF value.
   */
  public function edtfMax (string|null $value): int|null {
    $this->init();

    $parsingResult = $this->parser->parse($value ?? '');
    if (!$parsingResult->isValid()) {
      return null;
    }

    $edtfValue = $parsingResult->getEdtfValue();

    return $edtfValue->getMax();
  }
}
