<template>
    <div>
        <div class="event-card -shadow">
          <img :src="bid.avatarDir" class="images">
          <h4 class="title">{{ bid.bidAmount }}$</h4>
          <h5 class="username">{{ bid.user }}</h5>
          <span class="eyebrow"></span>
          <p>{{ bid.comment }}</p>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    bid: Object
  }
}
</script>

<style scoped>
.event-card {
      padding: 19px;
      margin-bottom: 5px;
      transition: all 0.2s linear;
      cursor: pointer;
    }
    .event-card:hover {
      transform: scale(1.01);
      box-shadow: 0 3px 12px 0 rgba(0, 0, 0, 0.2), 0 1px 15px 0 rgba(0, 0, 0, 0.19);
    }
    .event-card > .title {
      margin-left: 80px;
      margin-top: -80px;
    }

    .event-link {
      color: black;
      text-decoration: none;
      font-weight: 100;
    }
    .images {
      width: 14%;
      border: 1px solid  black;
       box-shadow: 0px .5px 1px #d8d8d8;
    }
    p {
      color: rgba(0, 0, 0, 0.6);
      padding-top: 3%;
      margin-bottom: -10px;

    }
    .username {
      margin-left: 80px;
      margin-bottom: -1%;
      margin-top: -5%;
      color: rgba(0, 0, 0, 0.6);
    }
    @media only screen and (max-width: 600px) {
    .event-card {
      padding: 19px;
      margin-bottom: 5px;
      transition: all 0.2s linear;
      cursor: pointer;
    }
    .event-card:hover {
      transform: scale(1.01);
      box-shadow: 0 3px 12px 0 rgba(0, 0, 0, 0.2), 0 1px 15px 0 rgba(0, 0, 0, 0.19);
    }
    .event-card > .title {
      margin-left: 70px;
      margin-top: -70px;
    }

    .event-link {
      color: black;
      text-decoration: none;
      font-weight: 100;
    }
    .images {
      width: 20%;
      border: 1px solid  black;
       box-shadow: 0px .5px 1px #d8d8d8;
    }
    p {
      color: rgba(0, 0, 0, 0.6);
      padding-top: 3%;
      margin-bottom: -10px;

    }
    .username {
      margin-left: 70px;
      margin-bottom: -1%;
      margin-top: -10%;
      color: rgba(0, 0, 0, 0.6);
    }
    }

</style>
