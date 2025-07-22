<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TawkToFilter implements FilterInterface
{
    /**
     * We don't need to do anything before the controller runs.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //
    }

    /**
     * Injects the Tawk.to script just before the closing </body> tag
     * on every full HTML page.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Don't inject on redirects or non-HTML responses (like JSON APIs)
        if ($response->hasHeader('Location') || strpos($response->getHeaderLine('Content-Type'), 'text/html') === false) {
            return;
        }

        $body = $response->getBody();

        if (empty($body) || strpos($body, '</body>') === false) {
            return;
        }

        // Render the tawk.to partial view and inject it
        $tawkToScript = view('templates/tawkto');
        $response->setBody(str_ireplace('</body>', $tawkToScript . '</body>', $body));

        return $response;
    }
}
