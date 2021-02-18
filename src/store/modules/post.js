import EventService from '@/services/EventService.js'

export const namespaced = true

export const state = {
  posts: [],
  totalPosts: 0,
  post: {},
  perPage: 3
}

export const mutations = {
  ADD_POST (state, post) {
    state.posts.push(post)
  },
  SET_POSTS (state, posts) {
    state.posts = posts
  },
  SET_TOTAL_POSTS (state, nbOfTotalPosts) {
    state.totalPosts = nbOfTotalPosts
  },
  SET_POST (state, post) {
    state.post = post
  }
}
export const actions = {
  createPost ({ commit, dispatch }, post) {
    return EventService.postPost(post)
      .then(() => {
        commit('ADD_POST', post)
        const notification = {
          type: 'success',
          message: 'Your post has been created!'
        }
        dispatch('notification/add', notification, { root: true })
      })
      .catch(error => {
        const notification = {
          type: 'error',
          message: 'There was a problem creating your post: ' + error.message
        }
        dispatch('notification/add', notification, { root: true })
        throw error
      })
  },
  fetchPosts ({ commit, dispatch, state }, { page }) {
    let totalPosts = 0
    EventService.getNbOfPosts()
      .then(response => {
        var p = Promise.resolve(response.data.data)
        p.then(v => {
          totalPosts = v.length
        })
      })
    return EventService.getPosts(state.perPage, page)
      .then(response => {
        commit('SET_TOTAL_POSTS', totalPosts)
        commit('SET_POSTS', response.data.records)
      })
      .catch(error => {
        const notification = {
          type: 'error',
          message: 'There was a problem fetching posts: ' + error.message
        }
        dispatch('notification/add', notification, { root: true })
      })
  },
  fetchPost ({ commit, getters, state }, id) {
    var post = getters.getPostById(id)

    if (post) {
      commit('SET_POST', post)
      return post
    } else {
      return EventService.getPost(id)
        .then(response => {
          commit('SET_POST', response.data.records)
          return response.data.records
        })
    }
  }
}
export const getters = {
  numberOfPosts: state => {
    return state.posts.length
  },
  getPostById: state => id => {
    return state.posts.find(post => post.id === id)
  }
}
