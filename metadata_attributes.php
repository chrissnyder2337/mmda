<?php


$metadata_attributes = array(
  'resource_name' => array(
    'filterable' => TRUE,
    'display' => 'Filename',
    'table' => 'File',
    'tika_alias' => array('resourceName')
    ),
  'local_path' => array(
    'filterable' => TRUE,
    'display' => 'Local Path',
    'table' => 'File',
    'tika_alias' => array()
    ),
  'external_path' => array(
    'filterable' => TRUE,
    'display' => 'External URL',
    'table' => 'File',
    'tika_alias' => array()
    ),
  'content_type' => array(
    'filterable' => TRUE,
    'display' => 'Content Type',
    'table' => 'File',
    'tika_alias' => array('Content-Type')
    ),
  'content_length' => array(
    'filterable' => TRUE,
    'display' => 'File Size',
    'table' => 'File',
    'tika_alias' => array('Content-Length')
    ),
  'md5_hash' => array(
    'filterable' => TRUE,
    'display' => 'md5 Hash',
    'table' => 'File',
    'tika_alias' => array()
    ),
  'audio_bitrate' => array(
    'filterable' => TRUE,
    'display' => 'Audio Bitrate',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_samplerate' => array(
    'filterable' => TRUE,
    'display' => 'Audio Samplerate',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'channels' => array(
    'filterable' => TRUE,
    'display' => 'Number of Audio Channels',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'channel_type' => array(
    'filterable' => TRUE,
    'display' => 'Audio Channel',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_format' => array(
    'filterable' => TRUE,
    'display' => 'Audio Format',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'track_number' => array(
    'filterable' => TRUE,
    'display' => 'Audio Track',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'title' => array(
    'filterable' => TRUE,
    'display' => 'Audio Track',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'genre' => array(
    'filterable' => TRUE,
    'display' => 'Audio Genre',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'duration' => array(
    'filterable' => TRUE,
    'display' => 'Audio Duration',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'artist' => array(
    'filterable' => TRUE,
    'display' => 'Artist',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'album' => array(
    'dispaly' => 'Album',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'audio_compression' => array(
    'filterable' => TRUE,
    'display' => 'Audio Compression',
    'table' => 'AudioMetadata',
    'tika_alias' => array()
    ),
  'created_date' => array(
    'filterable' => TRUE,
    'display' => 'Created Date',
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('Creation-Date','meta:creation-date','dcterms:created','Date/Time Original')
    ),
  'last_modified_date' => array(
    'filterable' => TRUE,
    'display' => 'Last Modified Date',
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('modified','dcterms:modified','date','Last-Modified')
    ),
  'image_count' => array(
    'filterable' => TRUE,
    'display' => 'Image Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'page_count' => array(
    'filterable' => TRUE,
    'display' => 'Page Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),  
  'table_count' => array(
    'filterable' => TRUE,
    'display' => 'Table Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),  
  'paragraph_count' => array(
    'filterable' => TRUE,
    'display' => 'Paragraph Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'character_count' => array(
    'filterable' => TRUE,
    'display' => 'Character Count (without spaces)',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'word_count' => array(
    'filterable' => TRUE,
    'display' => 'Word Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'character_count_with_space' => array(
    'filterable' => TRUE,
    'display' => 'Character Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'slide_count' => array(
    'filterable' => TRUE,
    'display' => 'Slide Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array()
    ),
  'architecture_bits' => array(
    'filterable' => TRUE,
    'display' => 'Architecture Bits',
    'table' => 'ExecutableMetadata',
    'tika_alias' => array()
    ),
  'machine_type' => array(
    'filterable' => TRUE,
    'display' => 'Machine Type',
    'table' => 'ExecutableMetadata',
    'tika_alias' => array()
    ),
  'machine_platform' => array(
    'filterable' => TRUE,
    'display' => 'Machine Platform',
    'table' => 'ExecutableMetadata',
    'tika_alias' => array()
    ),
  'x_resolution' => array(
    'filterable' => TRUE,
    'display' => 'X Axis Resolution',
    'table' => 'ImageResolutionMetadata',
    'tika_alias' => array()
    ),
  'y_resoltuion' => array(
    'filterable' => TRUE,
    'display' => 'Y Axis Resolution',
    'table' => 'ImageResolutionMetadata',
    'tika_alias' => array()
    ),
  'resolution_units' => array(
    'filterable' => TRUE,
    'display' => 'Resolution Units',
    'table' => 'ImageResolutionMetadata',
    'tika_alias' => array()
    ),
  'video_datarate' => array(
    'filterable' => TRUE,
    'display' => 'Video Datarate',
    'table' => 'VideoMetadata',
    'tika_alias' => array()
    ),
  'video_format' => array(
    'filterable' => TRUE,
    'display' => 'Video Format',
    'table' => 'VideoMetadata',
    'tika_alias' => array()
    ),
  'video_duration' => array(
    'filterable' => TRUE,
    'display' => 'Video Duration',
    'table' => 'VideoMetadata',
    'tika_alias' => array()
    ),
  'audio_duration' => array(
    'filterable' => TRUE,
    'display' => 'Audio Duration',
    'table' => 'VideoMetadata',
    'tika_alias' => array()
    ),
  'webpage_title' => array(
    'filterable' => TRUE,
    'display' => 'Webpage Title',
    'table' => 'WebpageMetadata',
    'tika_alias' => array()
    )
  );



