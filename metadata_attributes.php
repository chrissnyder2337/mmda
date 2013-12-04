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
  'audio_sample_rate' => array(
    'filterable' => TRUE,
    'display' => 'Audio Samplerate',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:audioSampleRate','samplerate')
    ),
  'channels' => array(
    'filterable' => TRUE,
    'display' => 'Number of Audio Channels',
    'table' => 'AudioMetadata',
    'tika_alias' => array('channels')
    ),
  'channel_type' => array(
    'filterable' => TRUE,
    'display' => 'Audio Channel',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:audioChannelType')
    ),
  'audio_format' => array(
    'filterable' => TRUE,
    'display' => 'Audio Format',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:audioCompressor')
    ),
  'track_number' => array(
    'filterable' => TRUE,
    'display' => 'Audio Track',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:trackNumber')
    ),
  'title' => array(
    'filterable' => TRUE,
    'display' => 'Audio Title',
    'table' => 'AudioMetadata',
    'tika_alias' => array('dc:title')
    ),
  'genre' => array(
    'filterable' => TRUE,
    'display' => 'Audio Genre',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:genre')
    ),
  'duration' => array(
    'filterable' => TRUE,
    'display' => 'Duration',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:duration') // for some reason duration does'nt show
    ),
  'artist' => array(
    'filterable' => TRUE,
    'display' => 'Artist',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:artist', 'xmpDM:composer')
    ),
  'album' => array(
    'dispaly' => 'Album',
    'table' => 'AudioMetadata',
    'tika_alias' => array('xmpDM:album')
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
  'author' => array(
    'filterable' => TRUE,
    'display' => 'Author',
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('dc:creator', 'creator', 'Author', 'meta:author')
    ),
  'title' => array(
    'filterable' => TRUE,
    'display' => 'Title',
    'table' => 'AuthoringMetadata',
    'tika_alias' => array('dc:title', 'title')
    ),
  'image_count' => array(
    'filterable' => TRUE,
    'display' => 'Image Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array('meta:image-count', 'nbImg', 'Image-Count')
    ),
  'page_count' => array(
    'filterable' => TRUE,
    'display' => 'Page Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array('xmpTPg:NPages', 'meta:page-count', 'Page-Count', 'nbPage')
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
    'tika_alias' => array('meta:paragraph-count', 'Paragraph-Count', 'nbPara')
    ),
  'character_count' => array(
    'filterable' => TRUE,
    'display' => 'Character Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array('meta:character-count', 'Character-Count', 'nbCharacter')
    ),
  'word_count' => array(
    'filterable' => TRUE,
    'display' => 'Word Count',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array('meta:word-count', 'Word-Count', 'nbWord')
    ),
  'character_count_with_space' => array(
    'filterable' => TRUE,
    'display' => 'Character Count (with spaces)',
    'table' => 'DocumentCountsMetadata',
    'tika_alias' => array('meta:character-count-with-spaces', 'Character-Count-With-Spaces')
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
    'tika_alias' => array('width', 'tiff:ImageWidth', 'Image Height')
    ),
  'y_resolution' => array(
    'filterable' => TRUE,
    'display' => 'Y Axis Resolution',
    'table' => 'ImageResolutionMetadata',
    'tika_alias' => array('height', 'tiff:ImageLength', 'Image Width')
    ),
  'resolution_units' => array(
    'filterable' => TRUE,
    'display' => 'Resolution Units',
    'table' => 'ImageResolutionMetadata',
    'tika_alias' => array('Data PlanarConfiguration', 'Resolution Units')
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



