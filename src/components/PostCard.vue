<template>
<router-link class="event-link" :to="{ name: 'product', params: { id: post.id } }" :post="post">
    <div class="event-card -shadow">
        <img :src="post.imageDir" class="images">
        <span class="eyebrow"></span>
        <h4 class="title">{{ post.title }}</h4>
        <p> {{post.location}} | Size: {{ post.size }} | Category: {{post.category}} | owner: {{ post.user ? post.user: 'what' }} | Price: {{ post.price }}$
        </p>
        <!-- ../../assets/static/Jordan 1 Retro High Court Purple White.jpg -->
      </div>
    </router-link>
</template>

<script>
export default {
  props: {
    post: Object
  }
}
</script>

<style scoped>
.event-card {
      padding: 19px;
      margin-bottom: 10px;
      transition: all 0.2s linear;
      cursor: pointer;
    }
    .event-card:hover {
      transform: scale(1.01);
      box-shadow: 0 3px 12px 0 rgba(0, 0, 0, 0.2), 0 1px 15px 0 rgba(0, 0, 0, 0.19);
    }
    .event-card > .title {
      margin-left: 140px;
      margin-top: -75px;
    }

    .event-link {
      color: black;
      text-decoration: none;
      font-weight: 100;
    }
    .images {
      width: 30%;
    }
    p {
      color: rgba(0, 0, 0, 0.6);
      padding-top: 3%;
      margin-bottom: -10px;

    }
</style>
