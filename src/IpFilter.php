<?php

namespace Jpgfe\Slim\IpFilter;

use Respect\Validation\Validator as Validator;

/**
 * IpFilter for Slim.
 */
class IpFilter
{
    protected $options;
    /**
    * Create new IpFilter service provider.
    *
    * @param array $options
    */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
    * IpFilter middleware invokable class.
    *
    * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
    * @param \Psr\Http\Message\ResponseInterface  $response PSR7 response
    * @param callable $next Next middleware
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function __invoke($request, $response, $next)
    {
        $ipAddress = $request->getAttribute('ip_address');
        $isallow = false;
        foreach ($this->options as $option) {
            if (is_array($option['ip'])) {
                foreach ($option['ip'] as $ipOption) {
                    if (Validator::ip($ipOption)->validate($ipAddress)) {
                        $isallow = isset($option['allow']) ? $option['allow'] : false;
                    }
                }
                if ($isallow === false) {
                    return $response->withStatus(403);
                }
                
            }elseif (!Validator::ip($option['ip'])->validate($ipAddress)) {
                return $response->withStatus(403);
            }
            
        }
        return $next($request, $response);
    }

    /**
    * Get the options array.
    *
    * @return array
    */
    public function getOptions()
    {
        return $this->options;
    }

    /**
    * Set the options array.
    *
    * @param array $options The options array.
    */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
