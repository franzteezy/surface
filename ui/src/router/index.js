import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    //PAGES THAT DOESNT REQUIRE AUTH
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Base.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/core/Login.vue')
    },
    {
      path: '/forgot',
      name: 'forgot-password-step-one',
      component: () => import('../views/core/ForgotPassword.vue')
    },
    {
      path: '/forgot/:token',
      name: 'reset-password',
      component: () => import('../views/core/ResetPassword.vue')
    },
    {
      path: '/register/:token',
      name: 'register',
      component: () => import('../views/core/Register.vue')
    },

    //CRM PAGES
    {
      path: '/settings',
      name: 'settings',
      meta: {
        permissions: ['settings'],
        menu: 'crm',
      },
      component: () => import('../views/core/settings/Settings.vue')
    },
    {
      path: '/settings/fields',
      name: 'settings-fields',
      redirect: '/settings/fields/fields',
      meta: {
        permissions: ['settings', 'fields'],
        menu: 'crm',
      },
      component: () => import('../views/core/settings/Fields.vue'),
      children: [
        {
          path: 'fields',
          name: 'settings-fields.fields',
          meta: {
            permissions: ['settings', 'fields', 'fields'],
            menu: 'crm',
          },
          component: () => import('../views/core/settings/fields/Fields.vue'),
        },
        {
          path: 'templates',
          name: 'settings-fields-templates',
          meta: {
            permissions: ['settings', 'fields', 'templates'],
            menu: 'crm',
          },
          component: () => import('../views/core/settings/fields/Templates.vue'),
        },
        {
          path: 'templates/create',
          name: 'settings-fields-templates-create',
          meta: {
            sub: false,
            permissions: ['settings', 'fields', 'templates'],
            menu: 'crm',
          },
          component: () => import('../views/core/settings/fields/CreateTemplate.vue'),
        },
      ]
    },

    //CRM PAGES
    {
      path: '/crm',
      redirect: '/crm/dashboard'
    },
    {
      path: '/crm/dashboard',
      name: 'crm-dashboard',
      meta: {
        permissions: ['crm', 'dashboard'],
        menu: 'crm',
      },
      component: () => import('../views/crm/Dashboard.vue')
    },
    {
      path: '/crm/create',
      name: 'crm-create',
      meta: {
        menu: 'crm',
      },
      component: () => import('../views/crm/Campaigns/Create.vue')
    },
    {
      path: '/crm/campaigns',
      name: 'crm-campaigns',
      meta: {
        permissions: ['crm', 'campaigns'],
        menu: 'crm',
      },
      component: () => import('../views/crm/Campaigns/Overview.vue'),
      children: [
      ]
    },
    {
      path: '/crm/campaigns/:campaign',
      name: 'crm-campaigns-single-view',
      meta: {
        menu: 'crm',
      },
      component: () => import('../views/crm/Campaigns/Single.vue'),
      children: [
        {
          path: 'pipeline',
          name: 'crm-campaigns-single-view-pipeline',
          component: () => import('../views/crm/Campaigns/Pipeline.vue'),
        },
        {
          path: 'customers',
          name: 'crm-campaigns-single-view-customers',
          component: () => import('../views/crm/Campaigns/Customers.vue'),
        },
        {
          path: 'orders',
          name: 'crm-campaigns-single-view-orders',
          component: () => import('../views/crm/Campaigns/Orders.vue'),
        },
      ]
    },
    {
      path: '/crm/customers',
      name: 'crm-customers',
      meta: {
        menu: 'crm',
      },
      component: () => import('../views/crm/Customers/Overview.vue')
    },
    {
      path: '/crm/customers/:hash',
      name: 'crm-customers-single-view',
      meta: {
        menu: 'crm',
      },
      component: () => import('../views/crm/Customers/Single.vue')
    },

    //DEV GUIDE PAGES<
    {
      path: '/developer-guide/fields',
      name: 'dev-guide-fields',
      component: () => import('../views/devguide/Fields.vue')
    },
    {
      path: '/developer-guide/buttons',
      name: 'dev-guide-buttons',
      component: () => import('../views/devguide/Buttons.vue')
    },
    {
      path: '/developer-guide/notifications',
      name: 'dev-guide-notifications',
      component: () => import('../views/devguide/Notifications.vue')
    },
    {
      path: '/developer-guide/dynamics',
      name: 'dev-guide-dynamics',
      component: () => import('../views/devguide/Dynamics.vue')
    },

    //MAILER PAGE
    {
      path: '/mailer',
      name: 'mailer',
      redirect:'/mailer/inbox-list',
      component: () => import('../views/core/mailer/Mailer.vue'),
      children: [
        {
          path: 'inbox-list',
          name: 'mailer-inbox-list',
          component: () => import('../views/core/mailer/side-nav/MailList.vue'),
          children:[
            {
              path: ':id',
              name: 'mailer-inbox-id', 
              component: () => import('../views/core/mailer/side-nav/Mail.vue')
            },
          ]
        },
          
        {
          path: 'draft',
          name: 'mailer-draft',
          component: () => import('../views/core/mailer/side-nav/MailList.vue'),
          children:[
            {
              path: ':id',
              name: 'mailer-draft-id', 
              component: () => import('../views/core/mailer/side-nav/Mail.vue')
            },
          ]
        },
        {
          path: 'sent',
          name: 'mailer-sent',
          component: () => import('../views/core/mailer/side-nav/MailList.vue'),
          children:[
            {
              path: ':id',
              name: 'mailer-sent-id', 
              component: () => import('../views/core/mailer/side-nav/Mail.vue')
            },
          ]
        },
        {
          path: 'deleted',
          name: 'mailer-deleted',
          component: () => import('../views/core/mailer/side-nav/MailList.vue'),
          children:[
            {
              path: ':id',
              name: 'mailer-deleted-id', 
              component: () => import('../views/core/mailer/side-nav/Mail.vue')
            },
          ]
        },
        {
          path: 'favorites',
          name: 'mailer-favorites',
          component: () => import('../views/core/mailer/side-nav/Favorites.vue')
        },
        {
          path: 'chats',
          name: 'core-chats',
          component: () => import('../views/core/chats/Chats.vue'),
          children:[
            {
              path: ':id',
              name: 'core-chats-id', 
              component: () => import('../views/core/chats/Chats.vue')
            },
          ]
        }
      ]
    },
  ]
})

export default router
