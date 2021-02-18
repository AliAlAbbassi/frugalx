<template>
  <div>
    <span
      :class="{ activeTab: selectedTab === tab }"
      v-for="(tab, index) in tabs"
      :key="index"
      @click="selectedTab = tab"
    >
      {{ tab }}</span
    >

    <div v-show="selectedTab === 'Reviews'">
      <p v-if="!reviews.length">There are no reviews yet.</p>
      <ul v-else>
        <li v-for="(review, index) in reviews" :key="index">
          <p>{{ review.name }}</p>
          <p>Rating: {{ review.rating }}</p>
          <p>{{ review.review }}</p>
        </li>
      </ul>
    </div>

    <ProductReview v-show="selectedTab === 'Make a Review'"></ProductReview>
  </div>
</template>

<script>
import ProductReview from './ProductReview.vue'
export default {
  components: {
    ProductReview
  },
  props: {
    reviews: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      tabs: ['Reviews', 'Make a Review'],
      selectedTab: 'Reviews'
    }
  }
}
</script>
