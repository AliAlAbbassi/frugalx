import Vue from 'vue'
import Router from 'vue-router'
import Home from '../views/Home.vue'
import Marketplace from '../views/Marketplace.vue'
import PostCreate from '../views/PostCreate.vue'
import Product from '@/components/Product.vue'
import UserProfile from '../views/UserProfile.vue'
import NProgress from 'nprogress'
import store from '@/store/store'
import NotFound from '../views/NotFound.vue'
import NetworkIssue from '../views/NetworkIssue.vue'
import Example from '../views/Example.vue'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/marketplace',
      name: 'marketplace',
      component: Marketplace,
      props: true
    },
    {
      path: '/marketplace/post-create',
      name: 'post-create',
      component: PostCreate
    },
    {
      path: '/example',
      component: Example
    },
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/marketplace/:id',
      name: 'product',
      component: Product,
      props: true,
      beforeEnter (routeTo, routeFrom, next) {
        store.dispatch('post/fetchPost', routeTo.params.id).then(post => {
          routeTo.params.post = post
          next()
        })
          .catch(error => {
            if (error.reponse && error.reponse.status === 404) {
              next({ name: '404', params: { resource: 'post' } })
            } else {
              next({ name: 'network-issue' })
            }
          })
      }
    },
    {
      path: '/profile',
      name: 'profile',
      component: UserProfile,
      props: true
    },
    {
      path: '/404',
      name: '404',
      component: NotFound,
      props: true
    },
    {
      path: '/network-issue',
      name: 'network-issue',
      component: NetworkIssue
    },
    {
      path: '*',
      redirect: { name: '404', params: { resource: 'page' } }
    }
  ]
})

router.beforeEach((routeTo, routeFrom, next) => {
  NProgress.start()
  next()
})

router.afterEach(() => {
  NProgress.done()
})

export default router
