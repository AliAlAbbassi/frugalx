import Vue from 'vue'
import Vuex from 'vuex'
import * as user from '@/store/modules/user.js'
import * as post from '@/store/modules/post.js'
import * as notification from '@/store/modules/notification.js'
import * as bid from '@/store/modules/bid.js'

Vue.use(Vuex)

export default new Vuex.Store({
  namespaced: true,
  modules: {
    user,
    post,
    notification,
    bid
  },
  state: {
    categories: ['Sneakers', 'Streetwear', 'Collectibles', 'Handbags', 'Watches']
  }
})
