<script setup>
import NewsService from '../services/NewsService';
import NewsItem from '../components/NewsItem.vue';
</script>

<template>
  <div class="main">

    <h1>News löschen</h1>

    <div v-if="!deleted && !nonExistend">
      <NewsItem :id="this.id" :title="item.title" :dateHR="item.dateHR" :content="item.content" :handles="handles">
      </NewsItem>

      <form class="newNewsItem">

        <div class="input-group mb-3">
          <button type="button" class="btn btn-warning" @click="deleteNews()">News löschen</button>
        </div>

      </form>
    </div>

    <div v-if="deleted">
      <div class="alert alert-success" role="alert">
        News gelöscht
      </div>
    </div>

    <div v-if="nonExistend">
      <div class="alert alert-danger" role="alert">
        News nicht verfügbar
      </div>
    </div>

  </div>
</template>

<script>
/**
 * + Grab the data from the api,
 * + stick it into the form,
 * + when the form gets updated stick the data back into the newsitem
 * + submit
 */
export default {
  props: ['id'],
  data() {
    return {
      item: [{
        'id': 0,
        'title': '',
        'date': 0,
        'content': ''
      }],
      handles: false,
      deleted: false,
      nonExistend: false
    }
  },
  beforeCreate() {
    NewsService.getNewsItem(this.$route.params.id)
      .then(response => {
        this.item = response.data
        this.item.dateHR = new Date(this.item.date * 1000).toUTCString() // unix timestamp in seconds, Date in milliseconds
      })
      .catch(error => {
        console.log(`Error inside NewsService.getNews from DeleteNewsItemView: ${error}`)
        this.nonExistend = true
      })
  },
  methods: {
    deleteNews() {
      NewsService.deleteNewsItem(this.id)
      this.deleted = true
    },
  },
}
</script>
