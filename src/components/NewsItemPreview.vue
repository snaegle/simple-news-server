<script setup>
import NewsItem from '../components/NewsItem.vue'
</script>

<template>

  <div class="preview">
    <h2>Vorschau</h2>
    <NewsItem :id="id" :title="title" :dateHR="dateHR" :content="content" :handles="handles">
    </NewsItem>
  </div>

</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: false
    },
    title: {
      type: String,
      required: false
    },
    dateHR: {
      type: String,
      required: true,
      default: ''
    },
    content: {
      type: String,
      required: false
    },
  },
  data() {
    return {
      handles: false
    }
  },
  created() {
    console.log(this.$props)
  }
}
</script>
