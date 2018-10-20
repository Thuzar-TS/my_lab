import Vue from 'vue'
import Router from 'vue-router'
import store from '../../../assets/js/store'

// Containers
import Full from '../containers/Full'

// Views
import Dashboard from '../views/Dashboard'
import Login from '../views/Login'
import Logout from '../views/Logout'

import Users from '../views/setups/Users'
import Roles from '../views/setups/Roles'
import Doctors from '../views/setups/Doctors'
import Patients from '../views/setups/Patients'
import Radiologics from '../views/setups/Radiologics'
import Locations from '../views/setups/Locations'
import LabGroups from '../views/setups/LabGroups'
import Units from '../views/setups/Units'
import States from '../views/setups/States'
import Brands from '../views/setups/Brands'
import DischargeTypes from '../views/setups/DischargeTypes'
import Items from '../views/setups/Items'
import Vendors from '../views/setups/Vendors'
import Categories from '../views/setups/Categories'

Vue.use(Router)

// export default new Router({
//   mode: 'history', // Demo is living in GitHub.io, so required!
//   linkActiveClass: 'open active',
//   scrollBehavior: () => ({ y: 0 }),
//   routes: [
//     {
//       path: '/',
//       redirect: '/dashboard',
//       name: 'Home',
//       component: Full,
//       children: [
//         {
//           path: 'dashboard',
//           name: 'Dashboard',
//           component: Dashboard
//         },
//         {
//           path: 'setups',
//           //redirect: '/setups/buttons',
//           name: 'Setups',
//           component: {
//             render (c) { return c('router-view') }
//           },
//           children: [
//             {
//               path: 'units',
//               name: 'Units',
//               component: Units
//             }
//           ]
//         }
//       ]
//     }
//   ]
// })

const routes = [
    {
        path: '/',
        redirect: { name: 'login' }
    },
    {
        path: '/dashboard',
        redirect: '/dashboard',
        name: 'Home',
        component: Full,
        children: [
            // redirect: { name: 'dashboard', component: Full }
            {
                path: '/dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: { requiresAuth: true }
            },
            {
                path: '/setups',
                name: 'Setup',
                component: {
                    render(c) { return c('router-view') }
                },
                children: [
                    {
                        path: 'users',
                        name: 'Users',
                        component: Users,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'roles',
                        name: 'Roles',
                        component: Roles,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'doctors',
                        name: 'Doctors',
                        component: Doctors,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'patients',
                        name: 'Patients',
                        component: Patients,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'radiologics',
                        name: 'Radiologics',
                        component: Radiologics,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'labgroups',
                        name: 'LabGroups',
                        component: LabGroups,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'locations',
                        name: 'Locations',
                        component: Locations,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'units',
                        name: 'Units',
                        component: Units,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'states',
                        name: 'States',
                        component: States,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'brands',
                        name: 'Brands',
                        component: Brands,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'categories',
                        name: 'Categories',
                        component: Categories,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'discharges',
                        name: 'DischargeTypes',
                        component: DischargeTypes,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'items',
                        name: 'Items',
                        component: Items,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: 'vendors',
                        name: 'Vendors',
                        component: Vendors,
                        meta: { requiresAuth: true }
                    }
                ]
            }
        ]
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout
    }
]

const router = new Router({
    mode: 'history', // Demo is living in GitHub.io, so required!
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes
})

router.beforeEach((to, from, next) => {
    //console.log(localStorage.getItem('token'));

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' })
        return
    }

    // if logged in redirect to dashboard
    if (to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' })
        return
    }

    next()
})

export default router