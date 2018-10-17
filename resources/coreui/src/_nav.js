export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer',
      badge: {
        variant: 'primary',
        //text: 'NEW'
      }
    },
    {
      name: 'Setup',
      url: '/components',
      icon: 'icon-puzzle',
      children: [                
        {
          name: 'Doctors',
          url: '/setups/doctors',
          icon: 'fa fa-user-md'
        },
        {
          name: 'Patients',
          url: '/setups/patients',
          icon: 'fa fa-wheelchair'
        },
        {
          name: 'Radiologics',
          url: '/setups/radiologics',
          icon: 'fa fa-user-md'
        },
        {
          name: 'Groups',
          url: '/setups/labgroups',
          icon: 'fa fa-usb'
        },
        {
          name: 'Locations',
          url: '/setups/locations',
          icon: 'fa fa-map-marker'
        },
        {
          name: 'States',
          url: '/setups/states',
          icon: 'icon-puzzle'
        },
        {
          name: 'Units',
          url: '/setups/units',
          icon: 'icon-puzzle'
        },
        {
          name: 'Brands',
          url: '/setups/brands',
          icon: 'icon-puzzle'
        },
        {
          name: 'Categories',
          url: '/setups/categories',
          icon: 'icon-puzzle'
        },
        {
          name: 'Discharge Types',
          url: '/setups/discharges',
          icon: 'icon-puzzle'
        }
      ]
    },
    {
      name: 'Security',
      url: '/components',
      icon: 'icon-puzzle',
      children: [
        {
          name: 'Users',
          url: '/setups/users',
          icon: 'fa fa-user'
        },
        {
          name: 'Roles',
          url: '/setups/roles',
          icon: 'icon-puzzle'
        }
      ]
    },
    {
      name: 'Logout',
      url: '/logout',
      icon: 'icon-speedometer',      
    }
  ]
}
