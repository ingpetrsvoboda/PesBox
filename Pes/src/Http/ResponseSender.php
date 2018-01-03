<?php

namespace Pes\Http;

/**
 * Description of ResponseSender
 *
 * @author pes2704
 */
class ResponseSender implements ResponseSenderInterface {
    /**
     * Send the response the client
     *
     * @param ResponseInterface $response
     */
    public function send(ResponseInterface $response) {
        // Send response
        if (!headers_sent()) {
            // Status
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));

            // Headers
            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }

        // Body
        if ( !in_array($response->getStatusCode(), [204, 205, 304])) {        //ResponseStatus->isEmpty($response)
            $body = $response->getBody();
            if ($body->isSeekable()) {
                $body->rewind();
            }
            //TODO: Svoboda !!! dočasná úprava - chunk site natvrdo 1024*8 - nemám settings
//            $settings       = $this->container->get('settings');
//            $chunkSize      = $settings['responseChunkSize'];
            $chunkSize      = 1024*8;
            $contentLength  = $response->getHeaderLine('Content-Length');
            if (!$contentLength) {
                $contentLength = $body->getSize();
            }


            if (isset($contentLength)) {
                $amountToRead = $contentLength;
                while ($amountToRead > 0 && !$body->eof()) {
                    $data = $body->read(min($chunkSize, $amountToRead));
                    echo $data;

                    $amountToRead -= strlen($data);

                    if (connection_status() != \CONNECTION_NORMAL) {
                        break;
                    }
                }
            } else {
                while (!$body->eof()) {
                    echo $body->read($chunkSize);
                    if (connection_status() != \CONNECTION_NORMAL) {
                        break;
                    }
                }
            }
        }
    }

    /**
     * https://github.com/http-interop
     */
    public function sendByInterop(ResponseInterface $response) {
        $http_line = sprintf('HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
        header($http_line, true, $response->getStatusCode());
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }
        $stream = $response->getBody();
        if ($stream->isSeekable()) {
            $stream->rewind();
        }
        while (!$stream->eof()) {
            echo $stream->read(1024 * 8);
        }        
    }    
}
