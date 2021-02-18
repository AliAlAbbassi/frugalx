import BidService from '@/services/BidService.js'

export const namespaced = true

export const state = {
  bids: [],
  totalBids: 0,
  bid: {},
  perPage: 3
}

export const mutations = {
  ADD_BID (state, bid) {
    state.bids.push(bid)
  },
  SET_BIDS (state, bids) {
    state.bids = bids
  },
  SET_TOTAL_BIDS (state, nbOfTotalBids) {
    state.totalBids = nbOfTotalBids
  },
  SET_BID (state, bid) {
    state.bid = bid
  }
}
export const actions = {
  createBid ({ commit, dispatch }, bid) {
    return BidService.postBid(bid)
      .then(() => {
        commit('ADD_BID', bid)
        const notification = {
          type: 'success',
          message: 'Your bid has been created!'
        }
        dispatch('notification/add', notification, { root: true })
      })
      .catch(error => {
        const notification = {
          type: 'error',
          message: 'There was a problem creating your bid: ' + error.message
        }
        dispatch('notification/add', notification, { root: true })
        throw error
      })
  },
  fetchBids ({ commit, dispatch, state }, { page }) {
    let totalBids = 0
    BidService.getNbOfBids()
      .then(response => {
        var p = Promise.resolve(response.data.data)
        p.then(v => {
          totalBids = v.length
        })
      })
    return BidService.getBids(state.perPage, page)
      .then(response => {
        commit('SET_TOTAL_BIDS', totalBids)
        commit('SET_BIDS', response.data.records)
      })
      .catch(error => {
        const notification = {
          type: 'error',
          message: 'There was a problem fetching bids: ' + error.message
        }
        dispatch('notification/add', notification, { root: true })
      })
  },
  fetchBid ({ commit, getters, state }, id) {
    var bid = getters.getBidById(id)

    if (bid) {
      commit('SET_BID', bid)
      return bid
    } else {
      return BidService.getBid(id)
        .then(response => {
          commit('SET_BID', response.data.records)
          return response.data.records
        })
    }
  }
}
export const getters = {
  numberOfBids: state => {
    return state.bids.length
  },
  getBidById: state => id => {
    return state.bids.find(bid => bid.id === id)
  }
}
