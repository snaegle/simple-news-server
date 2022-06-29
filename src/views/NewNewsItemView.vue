<script setup>
import NewsService from '../services/NewsService';
import DateRangePicker from '../../node_modules/vue3-daterange-picker'
import NewsItemPreview from '../components/NewsItemPreview.vue';
</script>

<template>
  <div class="main">

    <h1>Neue News erstellen</h1>
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
            :dateRange="dateRange" :singleDatePicker="singleDatePicker" ref="picker"
            @update:modelValue="onUpdateEndTime" :locale-data="{ firstDay: 1, format: 'dd.mm.yyyy, HH:mm' }"
            :timePicker="timePicker" :ranges="ranges">
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
        <textarea id="content" class="form-control" aria-label="Inhalt" v-model="item.content" @keydown="onChange"
          maxlength="280"></textarea>
      </div>

      <div class="input-group mb-3">
        <button type="button" class="btn btn-success" @click="submitNews()">News erstellen</button>
      </div>

    </form>

    <div class="alert alert-danger" role="alert" v-if="updated && !saved">
      Änderungen noch nicht gespeichert
    </div>

    <div class="alert alert-success" role="alert" v-if="saved">
      News erstellt
    </div>

    <NewsItemPreview :id="id" :title="item.title" :dateHR="item.dateHR" :content="item.content">
    </NewsItemPreview>

  </div>
</template>

<script>
export default {
  data() {
    let startDate = new Date();
    let endDate = new Date();
    endDate.setDate(endDate.getDate() + 6)
    return {
      item: [{
        'id': 0,
        'title': '',
        'date': 0,
        'dateHR': '',
        'content': '',
      }],
      loading: false,
      dateRange: { startDate, endDate },
      singleDatePicker: 'single',
      timePicker: true,
      ranges: false,
      date: new Date(), // date for daterangepicker
      updated: false,
      saved: true,
    }
  },
  created() {
    this.item.dateHR = new Date().toUTCString() // has to be initialized for preview
  },
  methods: {
    onUpdateEndTime(values) {
      console.log(values)
      this.item.dateHR = new Date(values.endDate).toUTCString()
    },
    onChange() {
      this.updated = true
      this.saved = false
    },
    submitNews() {
      this.item.date = parseInt(Date.parse(this.item.dateHR) / 1000) // unix timestamp in seconds, Date in milliseconds
      NewsService.newNewsItem(this.item.title, this.item.date, this.item.content)
        .then(response => {
          console.log(response)
        })
      this.item.title = ''
      this.item.content = ''
      this.item.dateHR = new Date().toUTCString() // has to be initialized for preview
      this.updated = false
      this.saved = true
    },
  }
}
</script>
