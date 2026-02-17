import { defineStore } from 'pinia'
import axios from '@/plugins/axios'
import router from '@/router'

interface User {
    id: number
    name: string
    email: string
}

interface AuthState {
    user: User | null
    token: string | null
}

interface LoginCredentials {
    email: string
    password: string
}

interface RegisterData extends LoginCredentials {
    name: string
    password_confirmation: string
}

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: localStorage.getItem('user') 
            ? JSON.parse(localStorage.getItem('user')!) 
            : null,
        token: localStorage.getItem('token') || null,
    }),
    
    getters: {
        isAuthenticated: (state): boolean => !!state.token && !!state.user,
    },
    
    actions: {
        async register(userData: RegisterData) {
            try {
                const response = await axios.post('/register', userData)
                this.setAuthData(response.data)
                router.push('/')
                return response
            } catch (error) {
                throw error
            }
        },
        
        async login(credentials: LoginCredentials) {
            try {
                const response = await axios.post('/login', credentials)
                this.setAuthData(response.data)
                router.push('/')
                return response
            } catch (error) {
                throw error
            }
        },
        
        async logout() {
            try {
                await axios.post('/logout')
            } catch (error) {
                console.error('Logout error:', error)
            } finally {
                this.clearAuthData()
                router.push('/login')
            }
        },
        
        async fetchUser() {
            try {
                const response = await axios.get('/user')
                this.user = response.data
                localStorage.setItem('user', JSON.stringify(response.data))
            } catch (error) {
                this.clearAuthData()
            }
        },
        
        setAuthData(data: any) {
            this.token = data.token
            this.user = data.user
            localStorage.setItem('token', data.token)
            localStorage.setItem('user', JSON.stringify(data.user))
        },
        
        clearAuthData() {
            this.token = null
            this.user = null
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        }
    }
})