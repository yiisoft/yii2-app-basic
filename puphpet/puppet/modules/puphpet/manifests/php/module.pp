/*
 * This "translates" PHP module package names into system-specific names.
 */

define puphpet::php::module (
  $service_autorestart
){

  $package = $::osfamily ? {
    'Debian' => {
      'apcu'      => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-apcu',
          '56'    => 'php-apcu',
          default => 'php5-apcu',
        },
        default  => 'php5-apcu',
      },
      'geoip'     => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-geoip',
          '56'    => 'php-geoip',
          default => 'php5-geoip',
        },
        default  => 'php5-geoip',
      },
      'imagick'   => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-imagick',
          '56'    => 'php-imagick',
          default => 'php5-imagick',
        },
        default  => 'php5-imagick',
      },
      'mbstring'  => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php7.0-mbstring',
          '56'    => 'php5.6-mbstring',
          default => false,
        },
        default  => false,
      },
      'memcache'  => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-memcache',
          '56'    => 'php-memcache',
          default => 'php5-memcache',
        },
        default  => 'php5-memcache',
      },
      'memcached' => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-memcached',
          '56'    => 'php-memcached',
          default => 'php5-memcached',
        },
        default  => 'php5-memcached',
      },
      'mongodb'   => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-mongodb',
          '56'    => 'php-mongodb',
          default => 'php5-mongo',
        },
        default  => 'php5-mongo',
      },
      'redis'     => $::operatingsystem ? {
        'ubuntu' => $puphpet::php::settings::version ? {
          '70'    => 'php-redis',
          '56'    => 'php-redis',
          default => 'php5-redis',
        },
        default  => 'php5-redis',
      },
    },
    'Redhat' => {
      #
    }
  }

  $downcase_name = downcase($name)

  if has_key($package, $downcase_name) {
    $package_name  = $package[$downcase_name]
    $module_prefix = false
  }
  else {
    $package_name  = $name
    $module_prefix = $puphpet::php::settings::prefix
  }

  if $package_name and ! defined(Php::Module[$package_name])
    and $puphpet::php::settings::enable_modules
  {
    ::php::module { $package_name:
      service_autorestart => $service_autorestart,
      module_prefix       => $module_prefix,
    }
  }

}
