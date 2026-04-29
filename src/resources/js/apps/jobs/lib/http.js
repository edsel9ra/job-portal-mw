import axios from 'axios'

export const http = axios.create({
  baseURL: '/api/jobs-api',
  headers: { Accept: 'application/json' },
})
