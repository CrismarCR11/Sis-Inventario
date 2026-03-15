<template>
  <v-row class="p-0 m-0">
    <v-col
      v-for="(field, index) in fields"
      :key="index"
      cols="12"
    >
      <v-skeleton-loader
        :type="getSkeletonType(field)"

        :height="getHeight(field)"
        :width="getWidth(field)"
      />
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
const props = defineProps<{
  fields: Array<'text' | 'select' | 'textarea' | 'button' | 'custom'>;
}>();

const getSkeletonType = (type: string) => {
  switch (type) {
    case "button":
      return "button";
    case "textarea":
      return "paragraph";
    case "custom":
      return "image";
    default:
      return "text";
  }
};

const getHeight = (type: string) => {
  switch (type) {
    case "button":
      return 40;
    case "textarea":
      return 100;
    default:
      return 44;
  }
};

const getWidth = (type: string) => {
  switch (type) {
    case "button":
      return "280px";
    default:
      return "100%";
  }
};
</script>

<style scoped>

::v-deep(.v-skeleton-loader__text) {
  margin: 0px !important;
  height: 44px !important;
  padding: 0px !important;
  background-color: rgba(0, 0, 0, 0.08);
}
::v-deep(.v-skeleton-loader__bone::after) {
  background: linear-gradient(90deg, rgba(255,255,255,0), rgba(200,200,200,0.5), rgba(255,255,255,0)) !important;
}
</style>