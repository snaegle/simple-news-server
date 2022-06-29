<script setup>
</script>

<template>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{ title }}&nbsp;</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ new Date(dateHR).toLocaleString('de-DE', {
          dateStyle: 'short',
          timeStyle: 'short'
        })
      }}
      </h6>
      <p class="card-text">{{ content }}&nbsp;</p>
    </div>
    <div class="handles" v-if="handles">
      <router-link class="" :to="{ name: 'EditNewsItemView', params: { id: id } }">
        <svg class="icon icon-pencil">
          <use xlink:href="#icon-pencil"></use>
        </svg>
      </router-link>
      <router-link class="" :to="{ name: 'DeleteNewsItemView', params: { id: id } }">
        <svg class="icon icon-bin">
          <use xlink:href="#icon-bin"></use>
        </svg>
      </router-link>
    </div>
  </div>

  <router-view />

</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    title: {
      type: String,
      required: true,
      default: ''
    },
    dateHR: {
      type: String,
      required: true,
      default: ''
    },
    content: {
      type: String,
      required: false,
      default: ''
    },
    handles: {
      type: Boolean,
      required: false,
      default: true
    }
  },
}
</script>
