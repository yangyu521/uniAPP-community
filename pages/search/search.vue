<template>
	<view>
		<template v-if="searchList.length === 0">
			<view class="py-2 font-md px-2">搜索历史</view>
			<view class="flex flex-wrap">
				<view class="border rounded font mx-2 my-1 px-2" hover-class="bg-light" @click="clickSearchHistory(item)" v-for="(item,index) in list"
				 :key="index">
					{{item}}
				</view>
			</view>
		</template>
		<template v-else>
			<block v-for="(item,index) in searchList" :key="index">
				<template v-if="type === 'post'">
					<common-list :item="item" :index="index"></common-list>
				</template>
				<template v-else-if="type === 'topic'">
					<!-- 话题 -->
				<topic-list :item="item" :index="index"></topic-list>
				</template>
				<template v-else="type === 'user'">
					<!-- 用户 -->
				<user-list :item="item" :index="index"></user-list>
				</template>
				
				<!-- 全局分割线 -->
				<divider></divider>
			</block>
		</template>

	</view>
</template>

<script>
	//测试数据
	const demo1 = [{
			username: "昵称",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: false,
			title: "我是标题",
			titlepic: "/static/demo/banner1.jpg",
			support: {
				type: "",
				support_count: 0,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		},
		{
			username: "杨雨",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: false,
			title: "我是标题",
			titlepic: "",
			support: {
				type: "unsupport",
				support_count: 1,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		},
		{
			username: "杨雨",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: false,
			title: "我是标题",
			titlepic: "",
			support: {
				type: "",
				support_count: 1,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		}
	]

	const demo2 = [{
			cover: "/static/demo/topicpic/1.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/2.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/3.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/4.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/5.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/6.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/7.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		},
		{
			cover: "/static/demo/topicpic/8.jpeg",
			title: "#话题名称#",
			desc: "话题描述",
			today_count: 0,
			news_count: 10
		}
	]

	const demo3 = [{
			avatar: "/static/default.jpg",
			username: "昵称",
			sex: 1, //0未知 1：女性 2：男性
			age: 24,
			isFellow: true
		},
		{
			avatar: "/static/default.jpg",
			username: "昵称",
			sex: 2, //0未知 1：女性 2：男性
			age: 24,
			isFellow: false
		}
	]

	import commonList from "@/components/common/common-list.vue"
	import topicList from "@/components/news/topic-list.vue"
	import userList from "@/components/user-list/user-list.vue"
	export default {
		components: {
			commonList,
			topicList,
			userList
		},
		data() {
			return {
				searchText: "",
				searchList: [],
				type: "post",
				list: ['Vue从精通到入门', "好好学习", "天天向上", "C++的学习"]
			}
		},
		onNavigationBarSearchInputChanged(e) {
			this.searchText = e.text;
		},
		onNavigationBarButtonTap(e) {
			if (e.index === 0) {
				this.searchEvent()
			}
		},
		onLoad(e) {
			if (e.type) {
				this.type = e.type
			}
			let pageTitle = '帖子'
			console.log(this.type)
			switch (this.type) {
				case 'post':
					pageTitle = '帖子'
					break;
				case 'topic':
					pageTitle = '话题'
					break;
				case 'user':
					pageTitle = '用户'
					break;
			}
			//修改搜索占位

			// #ifdef APP-PLUS
			let currentWebview = this.$mp.page.$getAppWebview()
			let tn = currentWebview.getStyle().titleNView
			tn.searchInput.placeholder = '搜索' + pageTitle
			currentWebview.setStyle({
				titleNView: tn
			})
			// #endif
		},
		methods: {
			//点击搜索历史
			clickSearchHistory(text) {
				this.searchText = text;
				this.searchEvent();
			},
			//搜索事件
			searchEvent() {
				//收起软键盘
				uni.hideKeyboard()
				//请求搜索
				//loading
				uni.showLoading({
					title: '加载中',
					musl: false
				})
				setTimeout(() => {
					switch(this.type){
						case 'post':
						this.searchList = demo1;
						break;
						case 'topic':
						this.searchList = demo2;
						break;
						case 'user':
						this.searchList = demo3;
						break;
					}
					uni.hideLoading()
				}, 1000)

			}
		}
	}
</script>

<style>

</style>
