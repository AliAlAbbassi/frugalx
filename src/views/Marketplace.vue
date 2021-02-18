<template>
    <div class="mother">
    <div class="icon-wrapper">
      <h2>Buy & Sell</h2>
      <router-link to="/marketplace/post-create" class="icon">
      <img src="../assets/plus-circle-solid.svg">
      </router-link>
    </div>
    <PostCard lowestbid="170$" class="cards" v-for="post in post.posts" :key="post.id" :post="post"/>
    <template v-if="page != 1">
    <router-link :to="{ name: 'marketplace', query: { page: page - 1 } }" rel="prev">
      Prev Page</router-link> |
      </template>
      <template v-if="isLastPage">
      <router-link :to="{ name: 'marketplace', query: { page: page + 1 } }" rel="next">
      Next Page</router-link>
      </template>
    <!-- <MediaBox>
      <h2 slot="heading">DaddyBruce</h2>
        <template>
      <p slot="paragraph">Yo these shoes are something else</p>
      </template>
      </MediaBox> -->

    </div>
</template>

<script>
import PostCard from '@/components/PostCard.vue'
import MediaBox from '@/components/MediaBox.vue'
import { mapState } from 'vuex'
import store from '@/store/store'

function getPagePosts (routeTo, next) {
  const currentPage = parseInt(routeTo.query.page) || 1
  store
    .dispatch('post/fetchPosts', {
      page: currentPage
    }).then(() => {
      routeTo.params.page = currentPage
      next()
    })
}

export default {
  props: {
    page: {
      type: Number,
      required: true
    }
  },
  components: {
    PostCard,
    MediaBox
  },
  beforeRouteEnter (routeTo, routeFrom, next) {
    getPagePosts(routeTo, next)
  },
  beforeRouteUpdate (routeTo, routeFrom, next) {
    getPagePosts(routeTo, next)
  },
  computed: {
    isLastPage () {
      if (this.post.totalPosts > this.page * this.post.perPage) {
        return true
      }
      return false
    },
    ...mapState(['post', 'user'])
  }
}
</script>
<style scoped>
.icon-wrapper {
    display: inline-flex;
    align-items: center;
}
.icon {
    width: 9%;
    padding-left: 230px;
    padding-top: 11px;

}
.mother {
  box-sizing: border-box;
  width: 500px;
  padding: 0 20px 20px;
  margin: 0 auto;
}
</style>
