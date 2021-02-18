<template>
    <div>
        <div>
            <h3>{{ user.name }}</h3>
            <!-- <div v-if="user.premium">
                <p>Account: Premium | Location: {{ user.location }}</p>
            </div>
            <p v-else>Account: Free | Location: {{ user.location }}</p> -->
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    numberOfPosts () {
      return this.$store.getters.numberOfPosts
    },
    ...mapState(['user', 'posts'])
  }
}

</script>

<style scoped>

</style>
