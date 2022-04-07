<template>
    <li class="shopcart">
        <a class="cartbox_active" href="#">
            <span v-if="unreadCount > 0" class="product_qun">{{ unreadCount }}</span>
        </a>
        <div class="block-minicart minicart__active">
            <div v-if="unreadCount > 0" class="minicart-content-wrapper">
                <div class="single__items">
                    <div class="miniproduct">

                        <div v-for="item in unread" :key="item.id" class="item01 d-flex mt--20">
                            <div class="thumb">
                                <a :href="`edit-comment/${item.data.id}`"
                                   @click="readNotifications(item)">
                                    <img alt="`${item.data.post_title}`" src="/frontend/images/icons/comment.png"></a>
                            </div>
                            <div class="content">
                                <h6><a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)">You have
                                    new comment on your post: {{ item.data.post_title }}</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    data: function () {
        return {
            read: {},
            unread: {},
            unreadCount: 0,
        }
    },
    created: function () {
        this.getNotifications();
        let userId = $('meta[name="userId"]').attr('content');
        Echo.private('App.Models.User.' + userId)
            .notification((notification) => {
                this.read.unshift(notification);
                this.unreadCount++;
            });
    },
    methods: {
        getNotifications() {
            axios.get('user/notifications/get').then(res => {
                this.read = res.data.read;
                this.unread = res.data.unread;
                this.unreadCount = res.data.unread.length;
            }).catch(error => Exception.handle(error))
        },
        readNotifications(notification) {
            axios.post('user/notifications/read', {id: notification.id}).then(res => {
                this.unread.splice(notification, 1);
                this.read.push(notification);
                this.unreadCount--;
            })
        }
    }
}
</script>
