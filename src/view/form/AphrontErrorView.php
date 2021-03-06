<?php

final class AphrontErrorView extends AphrontView {

  const SEVERITY_ERROR = 'error';
  const SEVERITY_WARNING = 'warning';
  const SEVERITY_NOTICE = 'notice';
  const SEVERITY_NODATA = 'nodata';

  private $title;
  private $errors;
  private $severity;
  private $id;
  private $insideDialogue;

  public function setInsideDialogue($inside_dialogue) {
    $this->insideDialogue = $inside_dialogue;
    return $this;
  }
  public function getInsideDialogue() {
    return $this->insideDialogue;
  }

  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  public function setSeverity($severity) {
    $this->severity = $severity;
    return $this;
  }

  public function setErrors(array $errors) {
    $this->errors = $errors;
    return $this;
  }

  public function setID($id) {
    $this->id = $id;
    return $this;
  }

  private function getBaseClass() {
    if ($this->getInsideDialogue()) {
      $class = 'aphront-error-view-dialogue';
    } else {
      $class = 'aphront-error-view';
    }
    return $class;
  }

  final public function render() {

    require_celerity_resource('aphront-error-view-css');

    $errors = $this->errors;
    if ($errors) {
      $list = array();
      foreach ($errors as $error) {
        $list[] = phutil_render_tag(
          'li',
          array(),
          phutil_escape_html($error));
      }
      $list = phutil_render_tag(
        'ul',
        array(
          'class' => 'aphront-error-view-list',
        ),
        implode("\n", $list));
    } else {
      $list = null;
    }

    $title = $this->title;
    if (strlen($title)) {
      $title = phutil_render_tag(
        'h1',
        array(
          'class' => 'aphront-error-view-head',
        ),
        phutil_escape_html($title));
    } else {
      $title = null;
    }

    $this->severity = nonempty($this->severity, self::SEVERITY_ERROR);

    $classes = array();
    $classes[] = $this->getBaseClass();
    $classes[] = 'aphront-error-severity-'.$this->severity;
    $classes = implode(' ', $classes);

    return phutil_render_tag(
      'div',
      array(
        'id' => $this->id,
        'class' => $classes,
      ),
      $title.
      phutil_render_tag(
        'div',
        array(
          'class' => 'aphront-error-view-body',
        ),
        $this->renderChildren().
        $list));
  }
}
