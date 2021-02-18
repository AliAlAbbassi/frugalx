<template>
<div class="wholething">
  <div class="product">
    <div class="product-image">
      <img :src="image"/>
    </div>

    <div class="product-info">
      <h3 class="someText">{{ title }}</h3>
      <h4>Ask is: {{ post.price }}$</h4>
      <button class="placeabid" @click="show"><p style="margin-left:8px; margin-top:12px">Place a bid</p></button>

      <div class="bidsSection">
        <BidAsk class="cards" v-for="bid in bid.bids" :key="bid.id" :bid="bid"></BidAsk>
      </div>
        <modals-container />
    </div>
    <h1>{{ post.bidAmount }}</h1>
    <form action="">
      <!-- <BaseInput
        label="Bid Amount"
        v-model="bid.bidAmount"
        type="text"
        placeholder="Minimum is"
        class="field"
        :class="{ error: $v.post.title.$error }"
        @blur="$v.post.title.$touch"
      >
        </BaseInput> -->
    </form>
  </div>
  </div>
</template>

<script>
import eventBus from './eventBus'
import ProductTabs from './ProductTabs'
// import NProgress from 'nprogress'
import store from '@/store/store'
import BidAsk from '@/components/BidAsk.vue'
import { mapState } from 'vuex'

function getPageBids (routeTo, next) {
  const currentPage = parseInt(routeTo.query.page) || 1
  store
    .dispatch('bid/fetchBids', {
      page: currentPage
    }).then(() => {
      routeTo.params.page = currentPage
      next()
    })
}
export default {
  components: {
    ProductTabs,
    BidAsk
  },
  props: {
    post: {
      type: Object,
      required: true
    },
    page: {
      type: Number,
      required: true
    }
  },
  beforeRouteEnter (routeTo, routeFrom, next) {
    getPageBids(routeTo, next)
  },
  beforeRouteUpdate (routeTo, routeFrom, next) {
    getPageBids(routeTo, next)
  },
  computed: {
    isLastPage () {
      if (this.bid.totalBids > this.page * this.bid.perPage) {
        return true
      }
      return false
    },
    ...mapState(['bid', 'user']),

    title () {
      return this.post.title
    },
    image () {
      return this.post.imageDir
    }
  },

  mounted () {
    eventBus.$on('review-submitted', productReview => {
      this.reviews.push(productReview)
    })
  },
  methods: {
    show () {
      this.$modal.show({
        template: `
    <div>
      <h1>This is created inline</h1>
      <p>{{ text }}</p>
    </div>
  `,
        props: ['text']
      }, {
        text: 'This text is passed as a property'
      }, {
        height: 'auto'
      }, {
        'before-close': (event) => { console.log('this will be called before the modal closes') }
      })
    }
  }

}
</script>

<style scoped>
/* small screens */
  @media only screen and (max-width: 600px){
    body {
      font-family: tahoma;
      color:#282828;
      margin: 0px;
    }
    img {
      border: 3px solid  black;
      width: 70%;
      margin-left: 0px;
      margin-right: 0px;
      box-shadow: 0px .5px 1px #d8d8d8;
    }

    .product-image {
      width: 80%;
    }

    .product-image,
    .product-info {
      margin-top: 10px;
      width: 50%;
    }

    .color-box {
      width: 40px;
      height: 40px;
      margin-top: 5px;
    }

    .cart {
      margin-right: 25px;
      float: right;
      border: 1px solid #d8d8d8;
      padding: 5px 20px;
    }

    button {
      margin-top: 30px;
      border: none;
      background-color: black;
      color: white;
      height: 40px;
      width: 100px;
      font-size: 14px;
    }

    .disabledButton {
      background-color: #d8d8d8;
    }

    .review-form {
      width: 400px;
      padding: 20px;
      margin: 40px;
      border: 1px solid #d8d8d8;
    }

    input {
      width: 100%;
      height: 25px;
      margin-bottom: 20px;
    }

    textarea {
      width: 100%;
      height: 60px;
    }

    .tab {
      margin-left: 20px;
      cursor: pointer;
    }

    .activeTab {
      color: purple;
      text-decoration: underline;
    }
    .someText{
        width: 100%;
    }

    .wholething{
      box-sizing: border-box;
      width: 600px;
      padding: 0 0px 0px;
      margin: 0 auto;

    }
    .placeabid{
      margin: 0%;
      margin-left: 65%;
      margin-top: -100%;
      margin-bottom: 5%;
    }
    .field {
  margin-bottom: 24px;
}
.mother{
  box-sizing: border-box;
  width: 500px;
  padding: 0 20px 20px;
  margin: 0px auto;
  margin-top: 20px;
}
.errorMessage {
  color: red;
}
}

  /* large screens */
  @media only screen and (min-width: 600px) {
    body {
      font-family: tahoma;
      color:#282828;
      margin: 0px;
    }

    .nav-bar {
      background: linear-gradient(90deg, purple, purple,blue);
      height: 60px;
      margin-bottom: 15px;
    }

    .product {
      display: flex;
      flex-flow: wrap;
      padding: 1rem;
    }

    img {
      border: 3px solid  black;
      width: 70%;
      margin: 40px;
      box-shadow: 0px .5px 1px #d8d8d8;
    }

    .product-image {
      width: 80%;
    }

    .product-image,
    .product-info {
      margin-top: 10px;
      width: 50%;
    }

    .color-box {
      width: 40px;
      height: 40px;
      margin-top: 5px;
    }

    .cart {
      margin-right: 25px;
      float: right;
      border: 1px solid #d8d8d8;
      padding: 5px 20px;
    }

    button {
      margin-top: 30px;
      border: none;
      background-color: black;
      color: white;
      height: 40px;
      width: 100px;
      font-size: 14px;
    }

    .disabledButton {
      background-color: #d8d8d8;
    }

    .review-form {
      width: 400px;
      padding: 20px;
      margin: 40px;
      border: 1px solid #d8d8d8;
    }

    input {
      width: 100%;
      height: 25px;
      margin-bottom: 20px;
    }

    textarea {
      width: 100%;
      height: 60px;
    }

    .tab {
      margin-left: 20px;
      cursor: pointer;
    }

    .activeTab {
      color: purple;
      text-decoration: underline;
    }
    .someText{

        width: 100%;
    }
    .placeabid{
      margin: 0%;
      margin-left: 66%;
      margin-top: -100%;
      margin-bottom: 1%;
    }
    .bidsSection {
      margin-right: 100px;
  }
  .wholething{
      box-sizing: border-box;
      width: 1250px;
      padding: 0 20px 20px;
      margin: 0 auto;
    }
    .field {
  margin-bottom: 24px;
}
.mother{
  box-sizing: border-box;
  width: 500px;
  padding: 0 20px 20px;
  margin: 0px auto;
  margin-top: 20px;
}
.errorMessage {
  color: red;
}
  }
</style>
