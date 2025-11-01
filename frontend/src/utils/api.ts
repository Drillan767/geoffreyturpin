import axios from 'axios'
import { getToken, removeToken, setToken } from './auth'

const API_BASE_URL = 'http://localhost:3000/api'

export const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
})

// Request interceptor to add JWT token
apiClient.interceptors.request.use(
  (config) => {
    const token = getToken()
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor to handle auth errors
apiClient.interceptors.response.use(
  (response) => {
    // If the response contains a new token, update it
    if (response.data.token) {
      setToken(response.data.token)
    }
    return response
  },
  (error) => {
    // Handle 401 (Unauthorized) and 403 (Forbidden) errors
    if (error.response && (error.response.status === 401 || error.response.status === 403)) {
      removeToken()
      // Redirect to login page
      if (typeof window !== 'undefined') {
        window.location.href = '/login'
      }
    }
    return Promise.reject(error)
  }
)
