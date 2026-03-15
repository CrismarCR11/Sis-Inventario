<template>
  <div class="button-skeleton-wrapper">
    <div 
      class="skeleton-button"
      :class="{
        'mobile': isMobile,
        'outlined': true,
        'rounded-pill': true
      }"
    >
      <div class="skeleton-icon"></div>
      <div class="skeleton-text"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue"
import { useDisplay } from "vuetify"

defineProps<{
  label?: string
}>()

const { mdAndDown } = useDisplay()
const isMobile = computed(() => mdAndDown.value)
</script>

<style scoped>
.button-skeleton-wrapper {
  display: inline-block;
}

.skeleton-button {
  position: relative;
  height: 40px;
  min-width: 180px;
  border: 2px solid rgba(0, 0, 0, 0.1);
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 16px;
  gap: 8px;
  animation: skeleton-pulse 1.5s infinite ease-in-out;
}

.skeleton-button.mobile {
  width: 100%;
}

.skeleton-icon {
  width: 20px;
  height: 20px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 50%;
}

.skeleton-text {
  width: 60px;
  height: 16px;
  background-color: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

@keyframes skeleton-pulse {
  0%, 100% {
    opacity: 0.6;
  }
  50% {
    opacity: 0.3;
  }
}
</style>