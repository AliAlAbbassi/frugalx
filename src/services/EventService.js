import axios from 'axios'
import NProgress from 'nprogress'

const apiClient = axios.create({
  baseURL: 'http://localhost/FrugalX-master/FrugalX_API/api/post',
  withCredentials: false,
  headers: {
    Accept: 'application/json, image/webp',
    'Content-Type': 'multipart/form-data'
  },
  timeout: 10000
})

apiClient.interceptors.request.use(config => {
  NProgress.start()
  return config
})

apiClient.interceptors.response.use(response => {
  NProgress.done()
  return response
})

export default {
  getPosts (perPage, page) {
    return apiClient.get('/read_paging.php?page=' + page)
  },
  getPost (id) {
    return apiClient.get('/read_single.php?id=' + id)
  },
  postPost (post) {
    return apiClient.post('/create.php', post)
  },
  getNbOfPosts () {
    return apiClient.get('/read.php')
  },
  postBid (bid) {
    return apiClient.post('/createBid.php', bid)
  }
}
