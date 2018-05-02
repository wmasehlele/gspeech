<?php
namespace App\Classes;
# Includes the autoloader for libraries installed with composer
# require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Speech\SpeechClient;

class SpeechToText {
    # Your Google Cloud Platform project ID
    private $projectId = 'meeting-minutes-202805';

    # Instantiates a client
    private $speech = null;
    private $fileName = "";
    private $options = null;

    public function __construct() {
        $this->speech = new SpeechClient([
            'projectId' => $this->projectId, 
            'languageCode' => 'en-US',
            'keyFilePath' => storage_path('/framework/sessions/Meeting Minutes-bc7ef7f32e11.json')
        ]);
        //$this->speech->setAccessType("offline");
        # The name of the audio file to transcribe
        $this->fileName = storage_path('/audios/audio.raw');

        # The audio file's encoding and sample rate
        $this->options = [
            'encoding' => 'LINEAR16',
            'sampleRateHertz' => 16000,
        ];
    }
    # Detects speech in the audio file
    public function ConvertSpeechToText (){
        $results = $this->speech->recognize(fopen($this->fileName, 'r'), $this->options);
        $textSpeech = "Transcription: ";
        foreach ($results as $result) {
            $textSpeech .= $result->alternatives()[0]['transcript'] . PHP_EOL;
        }
        return $textSpeech;
    }
}