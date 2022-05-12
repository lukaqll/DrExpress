<template>
    <div >  
      <v-app-bar
        color="deep-purple accent-4"
        dark
      >
        <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>
  
        <v-toolbar-title>{{user.name}}</v-toolbar-title>
  
        <v-spacer></v-spacer>
  
        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>
  
        <v-btn icon>
          <v-icon>mdi-filter</v-icon>
        </v-btn>
  
        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </v-app-bar>
        <div >

            <v-navigation-drawer
                v-model="drawer"
                :mini-variant.sync="mini"
                permanent
                absolute
                class="mt-16"
                elevation="15"
                app
            >

            <v-list-item class="px-2">
                <v-list-item-avatar>
                    <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
                </v-list-item-avatar>
        
                <v-list-item-title>John Leider</v-list-item-title>
        
                <v-btn
                    icon
                    @click.stop="mini = !mini"
                >
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
                </v-list-item>
                <v-divider></v-divider>
                <v-list dense>
                    <v-list-item
                        v-for="item in items"
                        :key="item.title"
                        link
                    >
                    <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
        
                    <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main app class="py-4 container">
                <slot/>
            </v-main>
        </div>
    </div>
</template>

<script>
export default {
  props: { user: Object },
  data () {
    return {
      drawer: true,
      items: [
        { title: 'Home', icon: 'mdi-home-city' },
        { title: 'My Account', icon: 'mdi-account' },
        { title: 'Users', icon: 'mdi-account-group-outline' },
      ],
      mini: true,
    }
  },
};
</script>