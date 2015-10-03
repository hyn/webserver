

<VirtualHost *:{{ $config->port->http or 80 }}>
    @if(isset($hostname))
        ServerAdmin {{ "webmaster\@" . $hostname->hostname }}
    @else
        ServerAdmin {{ "webmaster\@" .  $hostnames->first()->hostname }}
    @endif

    @if(isset($hostname))
        ServerName {{ $hostname->hostname }}
    @else
        @foreach($hostnames->lists('hostname') as $i => $hostname)
            @if($i == 0)
                ServerName {{ $hostname }}
            @else
                ServerAlias {{ $hostname }}
            @endif
        @endforeach
    @endif

    # public path, serving content
    DocumentRoot {{ public_path() }}
    # default document handling
    DirectoryIndex index.html index.php

    @if ($website->websiteUser)
    # user
        {{--RUidGid {{ $website->websiteUser }} {{ config('webserver.group', 'users') }}--}}
    @endif

    @if($website->directory->media())
        # media directory
        alias "/media/" "{{ $website->directory->media() }}"
    @endif

    # allow cross domain loading of resources
    Header set Access-Control-Allow-Origin "*"

    # logging
    ErrorLog {{ $log_path }}.error.log
    CustomLog {{ $log_path }}.access.log combined
</VirtualHost>


@if(isset($ssl))
<VirtualHost *:{{ $config->port->https or 443 }}>

    @if(isset($hostname))
        ServerAdmin webmaster\@{{ $hostname->hostname }}
    @else
        ServerAdmin webmaster\@{{ $hostnames->first()->hostname }}
    @endif

    @if(isset($hostname))
        ServerName {{ $hostname->hostname }}
    @else
        @foreach($hostnames->lists('hostname') as $i => $hostname)
            @if($i == 0)
                ServerName {{ $hostname }}
            @else
                ServerAlias {{ $hostname }}
            @endif
        @endforeach
    @endif

    # public path, serving content
    DocumentRoot {{ public_path() }}
    # default document handling
    DirectoryIndex index.html index.php

    @if ($website->websiteUser)
        # user
{{--        RUidGid {{ $website->websiteUser }} {{ config('webserver.group', 'users') }}--}}
    @endif

    @if($website->directory->media())
        # media directory
        alias "/media/" "{{ $website->directory->media() }}"
    @endif

    # allow cross domain loading of resources
    Header set Access-Control-Allow-Origin "*"

    # logging
    ErrorLog {{ $log_path }}.error.log
    CustomLog {{ $log_path }}.access.log combined

    # enable SSL
    SSLEngine On
    SSLCertificateFile {{ $ssl->pathCrt }}
    SSLCertificateChainFile {{ $ssl->pathCa }}
    SSLCertificateKeyFile {{ $ssl->pathKey }}

    <FilesMatch "\.(cgi|shtml|phtml|php)$">
    SSLOptions +StdEnvVars
    </FilesMatch>

    BrowserMatch "MSIE [2-6]" \
    nokeepalive ssl-unclean-shutdown \
    downgrade-1.0 force-response-1.0
    # MSIE 7 and newer should be able to use keepalive
    BrowserMatch "MSIE [17-9]" ssl-unclean-shutdown
</VirtualHost>
@endif