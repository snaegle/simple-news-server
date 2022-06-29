<script setup>
import NewsService from '../services/NewsService';
import NewsItemPreview from '../components/NewsItemPreview.vue'
import DateRangePicker from '../../node_modules/vue3-daterange-picker'
</script>

<template>
  <div class="main">

    <h1>News editieren</h1>
    <form class="newNewsItem">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="title">Titel</span>
        </div>
        <input type="text" class="form-control" aria-label="title" aria-describedby="title" v-model="item.title"
          @keydown="onChange">
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="date">Datum</span>
        </div>
        <div aria-label="date" aria-describedby="date" class="datePicker">
          <DateRangePicker class="form-control" aria-label="title" aria-describedby="date" v-model="dateRange"
            :dateRange="dateRange" :locale-data="localeData" :singleDatePicker="singleDatePicker" ref="picker"
            @update:modelValue="onUpdateEndTime" :timePicker="timePicker" :ranges="ranges">
            <template #date="data">
              <span class="small">{{ data.date }}</span>
            </template>
          </DateRangePicker>
        </div>
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Inhalt</span>
        </div>
        <textarea id="content" class="form-control" aria-label="Inhalt" v-model="item.content" maxlength="280"
          @keydown="onChange"></textarea>
      </div>

      <div class="input-group mb-3">
        <button type="button" class="btn btn-success" @click="submitNews()">News speichern</button>
      </div>

    </form>

    <div class="alert alert-danger" role="alert" v-if="updated && !saved">
      Änderungen noch nicht gespeichert
    </div>

    <div class="alert alert-success" role="alert" v-if="saved">
      News geändert
    </div>

    <NewsItemPreview :id="id" :title="item.title" :dateHR="item.dateHR" :content="item.content">
    </NewsItemPreview>

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
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    let startDate = new Date();
    let endDate = new Date();
    endDate.setDate(endDate.getDate() + 6)
    return {
      item: [{
        'id': 0,
        'title': '',
        'date': 0,
        'content': ''
      }],
      dateRange: { startDate, endDate },
      singleDatePicker: 'single',
      timePicker: true,
      localeData: { firstDay: 1, format: 'dd.mm.yyyy, HH:mm' },
      ranges: false,
      date: new Date(), // in daterangepicker
      handles: false, // handles to edit and delete news
      updated: false,
      saved: false,
    }
  },
  beforeCreate() {
    NewsService.getNewsItem(this.$route.params.id)
      .then(response => {
        this.item = response.data
        this.item.dateHR = new Date(this.item.date * 1000).toUTCString() // unix timestamp in seconds, Date in milliseconds
        this.dateRange = [this.item.dateHR, this.item.dateHR]
        this.$refs.picker.dateRange.startDate = this.item.dateHR
        this.$refs.picker.dateRange.endDate = this.item.dateHR
      })
      .catch(error => {
        console.log(`Error inside NewsService.getNews from EditNewsItemView: ${error}`)
      })
  },
  methods: {
    onUpdateEndTime(values) {
      this.item.dateHR = new Date(values.endDate).toUTCString()
      this.onChange()
    },
    onChange() {
      this.updated = true
      this.saved = false
    },
    submitNews() {
      this.item.date = parseInt(Date.parse(this.item.dateHR) / 1000) // unix timestamp in seconds, Date in milliseconds
      NewsService.editNewsItem(parseInt(this.id), this.item.title, this.item.date, this.item.content)
      this.updated = false
      this.saved = true
    },
  },
}
</script>
