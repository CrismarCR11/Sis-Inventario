<template>
  <v-container fluid class="fill-height">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Iniciar Sesión</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleSubmit">
              <v-text-field
                v-model="form.email"
                label="Email"
                prepend-icon="mdi-email"
                type="email"
                required
                :error-messages="errors.email"
              ></v-text-field>
              <v-text-field
                v-model="form.password"
                label="Contraseña"
                prepend-icon="mdi-lock"
                type="password"
                required
                :error-messages="errors.password"
              ></v-text-field>
              
              <v-alert v-if="errorMessage" type="error" class="mb-3">
                {{ errorMessage }}
              </v-alert>
              
              <v-btn
                type="submit"
                color="primary"
                block
                :loading="loading"
              >
                Ingresar
              </v-btn>
            </v-form>
          </v-card-text>
          <v-card-text class="text-center">
            <router-link to="/register">¿No tienes cuenta? Regístrate</router-link>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const loading = ref(false)
const errorMessage = ref('')
const errors = reactive({
    email: '',
    password: ''
})

const form = reactive({
    email: '',
    password: ''
})

const handleSubmit = async () => {
    loading.value = true
    errorMessage.value = ''
    errors.email = ''
    errors.password = ''
    
    try {
        await auth.login(form)
    } catch (error: any) {
        if (error.response?.data?.errors) {
            errors.email = error.response.data.errors.email?.[0] || ''
            errors.password = error.response.data.errors.password?.[0] || ''
        } else {
            errorMessage.value = error.response?.data?.message || 'Error al iniciar sesión'
        }
    } finally {
        loading.value = false
    }
}
</script>