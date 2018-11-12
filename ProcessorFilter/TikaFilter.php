<?php

namespace AdimeoDataSuite\ProcessorFilter;

use AdimeoDataSuite\Model\Datasource;
use AdimeoDataSuite\Model\ProcessorFilter;

class TikaFilter extends ProcessorFilter
{
  function getDisplayName()
  {
    return "Tika filter";
  }

  function getSettingFields()
  {
    return array(
      'java_path' => array(
        'type' => 'text',
        'label' => 'Path to java (E.g.: /usr/bin/java)',
        'required' => true
      ),
      'tika_path' => array(
        'type' => 'text',
        'label' => 'Path to Tika JAR file',
        'required' => true
      ),
      'output_format' => array(
        'type' => 'choice',
        'label' => 'Output format',
        'required' => true,
        'choices' => array(
          'Select >' => '',
          'HTML' => 'h',
          'Plain text' => 't',
        )
      )
    );
  }

  function getFields()
  {
    return array('output');
  }

  function getArguments()
  {
    return array(
      'filePath' => 'File path'
    );
  }

  function execute(&$document, Datasource $datasource)
  {
    $output = [];
    exec('"' . $this->getSettings()['java_path'] . '" -jar "' . $this->getSettings()['tika_path'] . '" -' . $this->getSettings()['output_format'] . ' "' . $this->getArgumentValue('filePath', $document) . '"', $output);


    return array(
      'output' => implode("\n", $output)
    );
  }

}