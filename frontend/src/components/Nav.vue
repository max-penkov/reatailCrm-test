<template>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="#navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <router-link class="navbar-brand" :to="{name: 'home'}">
          <img src="../assets/logo.png" alt="App" height="28" />
        </router-link>
      </div>
      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><router-link class="nav-link" :to="{name: 'home'}">Главная</router-link></li>
          <template>
            <li class="nav-item"><router-link class="nav-link" :to="{name: 'clients'}">Клиенты</router-link></li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>