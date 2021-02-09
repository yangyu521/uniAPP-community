<template>
	<view>
		<!-- TAB -->
		<view class="flex align-center"  style="height: 100rpx;">
			<view class="flex-1  flex align-center justify-center font-md font-weight-normal" v-for="(item,index) in tabBars"
			 :key="index" @click="clickChange(index)" :class="tabBarIndex === index ? 'font-lg font-weight-bold text-main' : ''">
				{{item.name}} <text v-if="item.num > 0" class="m-2">{{item.num}}</text>
			</view>
		</view>

		<!-- 列表 -->
		<swiper :duration="150" :current="tabBarIndex" @change="onChangeTab" :style="'height:'+scrollH+'px'">
			<swiper-item v-for="(item,index) in newslist" :key="index">
				<scroll-view scroll-y="true" :style="'height:'+scrollH+'px'" @scrolltolower="loadMore(index)">
					<!-- 有数据的情况下 -->
					<template v-if="item.list.length > 0">
						<block v-for="(item2,index2) in item.list" :key="index2">
							<!-- 	列表样式 -->
							<user-list :item="item2" :index="index2"></user-list>
						</block>
						<load-more :loadMore="item.loadMore" v-if="newslist.length > 10"></load-more>
					</template>
					<!-- 无数据的情况下 -->
					<template v-else>
						<no-thing></no-thing>
					</template>
				</scroll-view>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
	const demo = [{
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

	import loadMore from "@/components/common/load-more.vue"
	import noThing from "@/components/common/no-thing.vue"
	import userList from "@/components/user-list/user-list.vue"
	export default {
		components: {
			loadMore,
			noThing,
			userList
		},
		data() {
			return {
				scrollH: 600,
				tabBarIndex: 0,
				tabBars: [{
						name: "互关",
						num: 0
					},
					{
						name: "关注",
						num: 2
					}, {
						name: "粉丝",
						num: 5
					}
				],
				newslist: []
			}
		},
		onNavigationBarSearchInputClicked() {
			uni.navigateTo({
				url: "../search/search?type=user"
			})
		},
		onNavigationBarButtonTap() {
			uni.navigateBack({
				delta: 1
			})
		},

		methods: {
			clickChange(index) {
				this.tabBarIndex = index;
			},
			onChangeTab(e) {
				this.changeTab(e.detail.current)
			},
			changeTab(index) {
				this.tabBarIndex = index;
				this.scrollInto = 'tab' + index
			},
			loadMore(index) {
				//判断是否处于可加载状态（上拉加载更多）
				// this.newslist[index].loadMore = "加载中"
				let item = this.newslist[index];
				item.loadMore = "加载中";
				setTimeout(() => {
					//加载数据
					item.list = [...item.list, ...item.list]
					//恢复加载状态
					item.loadMore = "上拉加载更多"

				}, 3000)
			},
			follow(e) {
				//拿到选项卡对应的list
				let list = this.newslist[this.tabBarIndex].list
				console.log(this.newslist[this.tabBarIndex].list[e])
				console.log(e)
				// this.newslist[2].isFollow = true;
				list[e].isFollow = true
				uni.showToast({
					title: "关注成功"
				})
			},
			doSupport(e) {
				//拿到选项卡对应的list
				let list = this.newslist[this.tabBarIndex].list
				let item = list[e.index]
				let msg = e.type === 'support' ? '顶' : '踩'
				if (item.support.type === '') {
					item.support[e.type + '_count']++
				} else if (item.support.type === "support" && e.type === 'unsupport') {
					item.support.support_count--;
					item.support.unsupport_count++
				} else if (item.support.type === "unsupport" && e.type === 'support') {
					item.support.support_count++;
					item.support.unsupport_count--;
				}
				item.support.type = e.type
				uni.showToast({
					title: msg + "成功"
				})
			},
			getData() {
				let arr = [];
				for (let i = 0; i < this.tabBars.length; i++) {
					let obj = {
						loadMore: "上拉加载更多...",
						list: []
					}
					arr.push(obj)
					this.newslist = arr
					if (i < 3) {
						obj.list = demo;
					}
				}
			},
		},
		onLoad() {
			uni.getSystemInfo({
				success: res => {
					this.scrollH = res.windowHeight - uni.upx2px(100)
				}
			});
			this.getData();
		}
	}
</script>

<style>

</style>
