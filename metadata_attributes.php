<?php


$metadata_attributes = array(
  'resource_name' => array(
    'table' => 'File',
    'tika_alias' => array('resourceName')
    ),
  'local_path' => array(
    'table' => 'File',
    'tika_alias' => array()
    ),
  'external_path' => array(
    'table' => 'File',
    'tika_alias' => array()
    ),
  'content_type' => array(
    'table' => 'File',
    'tika_alias' => array('Content-Type')
    ),
  'content_length' => array(
    'table' => 'File',
    'tika_alias' => array('Content-Length')
    ),
  'md5_hash' => array(
    'table' => 'File',
    'tika_alias' => array()
    ),
  'audio_bitrate' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_samplerate' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'channels' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'channel_type' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_format' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'track_number' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'title' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'genre' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'duration' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'artist' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'album' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_compression' => array(
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'created_date' => array(
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('Creation-Date','meta:creation-date','dcterms:created','Date/Time Original')
    ),
  'last_modified_date' => array(
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('modified','dcterms:modified','date','Last-Modified')
    ),

  );


$metadata_aliases = array();
foreach ($metadata_attributes as $db_attribute => $db_attribute_properties) {
  foreach ($db_attribute_properties['tika_alias'] as $tika_alias) {
    $metadata_aliases[$tika_alias] = $db_attribute;
  }
}
