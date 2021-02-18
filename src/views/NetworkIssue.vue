<template>
    <div style="
    box-sizing: border-box;
    width: 500px;
    padding: 0 20px 20px;
    margin: 0 auto;">
        <h1>Uh-Oh!</h1>
        <h3>It looks like you're experiencing some network issues, please click the back button and try again</h3>
        <router-link :to="{ name: 'marketplace' }"> Or go back to the home page</router-link>
    </div>
</template>
