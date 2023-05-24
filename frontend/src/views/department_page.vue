<template>
  <div class="department_page">
    <div class="nav">
      <router-link :to="{ name: 'timesheet' }"> Табель </router-link>
      <router-link :to="{ name: 'shifts' }"> Смены </router-link>
    </div>
    <router-view></router-view>
  </div>
</template>

<script></script>

<style scoped></style>
