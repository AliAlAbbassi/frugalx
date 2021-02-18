<template>
    <div style="
    box-sizing: border-box;
    width: 500px;
    padding: 0 20px 20px;
    margin: 0 auto;">
        <h1>Oops!</h1>
        <h3>The {{ resource }} you're looking for is not here.</h3>
        <router-link :to="{ name: 'marketplace' }"> Back to the home page</router-link>
    </div>
</template>

<script>
export default {
  props: {
    resource: {
      type: String,
      required: true
    }
  }
}
</script>
