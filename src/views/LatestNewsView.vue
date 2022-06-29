<script setup>
import NewsService from '../services/NewsService';
import NewsItem from '../components/NewsItem.vue';
</script>

<template>
  <div class="main-100">

    <h1>News Übersicht</h1>

    <div v-if="items.length">
      <masonry-wall :items="items" :ssr-columns="1">
        <template #default="{ item }">
          <div style="width: 400px">
            <NewsItem :id="item.id" :title="item.title" :dateHR="item.dateHR" :content="item.content"></NewsItem>
          </div>
        </template>
      </masonry-wall>
    </div>
  </div>


  <div class="alert alert-dark" role="alert" v-if="!items.length">
    Keine News vorhanden.
    <router-link class="nav-item nav-link" to="/new">
      Hier können News erstellt werden.
    </router-link>

    <router-view />
  </div>

</template>
<script>
export default {
  data() {
    return {
      items: [{
        'id': 0,
        'title': '',
        'date': 0,
        'content': '',
      }],
      dateHR: {
        type: String,
        default: ''
      },
      message: ''
    }
  },
  created() {
    NewsService.getNews()
      .then(response => {
        this.items = response.data
        this.items.forEach(item => {
          item.dateHR = new Date(item.date * 1000).toUTCString() // unix timestamp in seconds, Date in milliseconds
          item.id = parseInt(item.id)
        })
      })
      .catch(error => {
        console.log(`Error inside NewsService.getNews from LatestNewsView: ${error}`)
      })

  },
}
</script>
