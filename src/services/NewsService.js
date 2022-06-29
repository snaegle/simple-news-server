import axios from 'axios'

const apiClient = axios.create({
  baseURL: 'http://localhost:8108',
  withCredentials: false,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
})

export default {
  getNews() {
    return apiClient.get('/news')
  },
  getNewsItem(id) {
    return apiClient.get('/news/'+id)
  },
  newNewsItem(title, date, content) {
    const news = {title: title, date: date, content: content}
    return apiClient.post('/news', news)
  },
  editNewsItem(id, title, date, content) {
    const news = {title: title, date: date, content: content}
    return apiClient.put('/news/'+id, news)
  },
  deleteNewsItem(id) {
    return apiClient.delete('/news/'+id)
  }
}
